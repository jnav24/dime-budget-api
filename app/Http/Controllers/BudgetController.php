<?php

namespace App\Http\Controllers;

use App\Models\BillType;
use App\Models\BudgetAggregation;
use App\Models\Budget;
use App\Models\IncomeType;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use \Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        try {
            $data = Budget::where('user_id', auth()->user()->id)
                ->with(['aggregations' => function ($query) {
                    $query->where('type', 'saved');
                }])
                ->orderBy('id', 'desc')
                ->get();

            // @todo the shorthand to get only aggregrations.value doesn't work, created this map instead
            return $this->respondWithOK([
                'budgets' => $data->map(function ($budget) {
                    $saved = $budget->aggregations->map(function ($aggregation) {
                        return collect([
                            'saved' => $aggregation->value,
                        ]);
                    });

                    return collect(array_merge([
                        'id' => $budget->id,
                        'name' => $budget->name,
                        'budget_cycle' => $budget->budget_cycle,
                    ], $saved->shift()->toArray()));
                }),
            ]);
        } catch (\Exception $e) {
            Log::error('BudgetController::getAllBudgets - ' . $e->getMessage());
            return $this->respondWithBadRequest([], 'Unable to retrieve budgets at this time');
        }
    }

    public function show($id)
    {
        try {
            $sql = Budget::where('user_id', auth()->user()->id)
                ->where('id', $id)
                ->with(['aggregations' => function ($query) {
                    $query->where('type', 'saved');
                }]);

            ['data' => $data, 'expenses' => $expenses] = $this->getAllRelationships($sql);

            return $this->respondWithOK([
                'budget' => [
                    'id' => $id,
                    'name' => $data->name,
                    'budget_cycle' => $data->budget_cycle,
                    'expenses' => $expenses,
                    'saved' => $data->aggregations->shift()->value,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('BudgetController::getSingleBudgetExpenses - ' . $e->getMessage());
            return $this->respondWithBadRequest([], 'Unable to retrieve budgets at this time');
        }
    }

    /**
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'cycle' => 'required',
                'expenses' => 'required',
            ]);

            if (empty($request->input('expenses')) || !is_array($request->input('expenses'))) {
                throw new \Exception('Invalid request');
            }

            $expenses = $request->input('expenses');
            $id = $request->input('id', null);

            $budget = Budget::firstOrCreate(
                ['id' => $id],
                [
                    'name' => $request->input('name'),
                    'budget_cycle' => $request->input('cycle'),
                    'user_id' => auth()->user()->id,
                ]
            );

            if (empty($id)) {
                $expenses['incomes'] = $this->generatePaidExpenses($request, $expenses['incomes']);
            }

            $budget->updated_at = Carbon::now()->format('Y-m-d H:i:s');
            $budget->save();
            $types = BillType::all();
            $returnExpenses = $this->saveExpenses($budget->id, $expenses);

            $this->setupAndSaveAggregation(
                $budget->id,
                $expenses,
                $types->filter(function ($type) {
                    return !$type->save_type;
                })->pluck('slug')->toArray()
            );
            $saved = $budget->aggregations->filter(function ($value, $key) {
                return $value->type === 'saved';
            });

            return $this->respondWithOK([
                'budget' => [
                    'id' => $budget->id,
                    'name' => $budget->name,
                    'budget_cycle' => $budget->budget_cycle,
                    'created_at' => $budget->created_at->toDateTimeString(),
                    'expenses' => $returnExpenses,
                    'saved' => $saved->shift()->value,
                ],
            ]);
        } catch (ValidationException $e) {
            return $this->respondWithBadRequest($e->errors(), 'Errors validating request.');
        } catch (\Exception $e) {
            Log::error('BudgetController::saveBudget - ' . $e->getMessage());
            return $this->respondWithBadRequest([], 'Unable to save budget at this time.');
        }
    }

    public function destroy($id) {
        try {
            $types = BillType::all();

            DB::beginTransaction();

            $budget = Budget::where('id', $id)
                ->where('user_id', auth()->user()->id)
                ->first();

            if (empty($budget)) {
                throw new \Exception('Budget ' . $id . ' does not exist');
            }

            foreach ($types as $type) {
                $model = 'App\\Model\\' . $type->model;

                if (class_exists($model)) {
                    $model::where('budget_id', $budget->id)->delete();
                }
            }

            $budget->delete();
            DB::commit();
            return $this->respondWithOK([]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('BudgetController::deleteBudget - ' . $e->getMessage());
            return $this->respondWithBadRequest([], 'Unable to delete budget at this time');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response|JsonResponse
     */
    public function deleteBudgetExpense(Request $request, $id)
    {
        try {
            $expenses = $request->input('expenses', null);

            if (empty($expenses) || !is_array($expenses)) {
                throw new \Exception('Expenses is either missing or value is not an array');
            }

            $budget = Budget::where('id', $id)
                ->where('user_id', auth()->user()->id)
                ->first();
            $types = BillType::all();

            if (empty($budget)) {
                throw new \Exception('Budget ' . $id . ' does not exist');
            }

            DB::beginTransaction();

            foreach ($expenses as $expense) {
                if (empty($expense['id']) || empty($expense['type'])) {
                    throw new \Exception('Expense id or type is missing');
                }

                $slugs = $types->pluck('slug');
                $index = $slugs->search($expense['type']);
                $type = $types[$index];

                if (empty($type)) {
                    throw new \Exception('Bill type ' . $expense['type'] . ' is not found');
                }

                $model = 'App\\Models\\' . $type->model;

                if (!class_exists($model)) {
                    throw new \Exception($model . ' model is not found');
                }

                $object = $model::where('id', $expense['id'])
                    ->where('budget_id', $budget->id)
                    ->first();

                if (!empty($object)) {
                    $object->delete();
                }
            }

            DB::commit();
            return $this->respondWithOK([]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('BudgetController::deleteBudgetExpense - ' . $e->getMessage());
            return $this->respondWithBadRequest([], 'Unable to delete budget expense at this time');
        }
    }

    /**
     * Setup and Save Aggregations
     *
     * @param integer | string $budgetId
     * @param array $allExpenses {
     *      @value array BillType
     * }
     * @param string[] $spent
     */
    private function setupAndSaveAggregation($budgetId, $allExpenses, $spent)
    {
        $earnedTotal = $this->getAggregationTotal(['incomes'], $allExpenses);
        $spentTotal = $this->getAggregationTotal($spent, $allExpenses);
        $savedTotal = number_format((float)($earnedTotal - $spentTotal), 2, '.', '');

        $this->saveAggregation($budgetId, 'earned', $earnedTotal);
        $this->saveAggregation($budgetId, 'saved', $savedTotal);
        $this->saveAggregation($budgetId, 'spent', $spentTotal);
    }

    /**
     * Get totals for aggregations
     *
     * @param string[] $attributes
     * @param array $allExpenses {
     *      @value array BillType
     * }
     * @return string
     */
    private function getAggregationTotal($attributes, $allExpenses)
    {
        $total = 0;

        $keys = array_keys($allExpenses);
        $intersect = array_intersect($attributes, $keys);

        foreach ($intersect as $key => $value) {
            foreach ($allExpenses[$value] as $item) {
                if ($this->canAddAmount($item)) {
                    $total = ((float)$item['amount'] + $total);
                }
            }
        }

        return number_format((float)$total, 2, '.', '');
    }

    /**
     * Checks to see if amount can be add to the aggregate table
     *
     * @param array $item
     * @return boolean
     */
    private function canAddAmount(array $item): bool
    {
        $result = false;

        if (!empty($item['amount'])) {
            $result = true;

            if (!empty($item['not_track_amount'])) {
                $result = !$item['not_track_amount'];
            }
        }

        return $result;
    }

    private function saveAggregation($budgetId, $type, $total): void
    {
        BudgetAggregation::firstOrCreate(
            [
                'budget_id' => $budgetId,
                'type' => $type,
                'user_id' => auth()->user()->id
            ],
            [
                'value' => $total,
            ]
        );
    }

    /**
     * For employment, create a record for all pay dates in a billing cycle based on user input
     *
     * @param Request $request
     * @param array $expenses {
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     * @return array {
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     */
    private function generatePaidExpenses(Request $request, $expenses)
    {
        $currentMonth = Carbon::createFromTimeString($request->input('cycle'));
        $results = [];

        foreach ($expenses as $job) {
            $type = IncomeType::find($job['income_type_id']);
            $startPay = Carbon::createFromTimeString($job['initial_pay_date']);
            $method = 'get_' . $this->convertSlugToSnakeCase($type->slug);

            if (method_exists($this, $method)) {
                $results = array_merge($results, $this->{$method}($job, $startPay, $currentMonth));
            } else {
                $results = array_merge($results, $job);
            }
        }

        return $results;
    }

    /**
     * Get weekly pay periods for a billing cycle; called dynamically from generatePaidExpenses()
     *
     * @param array $job {
     *      @value integer | string ['id']
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     * @param Carbon $startPay
     * @param Carbon $currentMonth
     * @return array {
     *      @value integer | string ['id']
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     */
    private function get_weekly($job, $startPay, $currentMonth)
    {
        $results = [];

        $day = $startPay->format('D');
        $month = $currentMonth->format('M');
        $initialDate = $startPay;

        for ($i = 1; $i < 8; $i++) {
            $date = Carbon::createFromTimeString($currentMonth->format('Y-m') . '-0' . $i .' 00:00:00');

            if ($date->format('D') === $day) {
                $initialDate = $date;
            }
        }

        $currentMonthWeek = $currentMonth->weekOfYear;

        if ($currentMonth->format('M') === 'Dec') {
            $nextMonthWeek = 52;
        } else {
            $nextMonthWeek = $currentMonth->addMonth()->weekOfYear;
        }

        for ($i = 0; $i <= ($nextMonthWeek-$currentMonthWeek); $i++) {
            if ($initialDate->format('M') === $month) {
                $results[] = [
                    'id' => $job['id'],
                    'name' => $job['name'],
                    'amount' => $job['amount'],
                    'income_type_id' => $job['income_type_id'],
                    'initial_pay_date' => $initialDate->toDateTimeString(),
                ];
            }

            $initialDate->addDays(7);
        }

        return $results;
    }

    /**
     * Get bi-weekly pay periods for a billing cycle; called dynamically from generatePaidExpenses()
     *
     * @param array $job {
     *      @value string ['id']; a temp id is expected
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     * @param Carbon $startPay
     * @param Carbon $currentMonth
     * @return array {
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     */
    private function get_bi_weekly($job, $startPay, $currentMonth)
    {
        $results = [];

        $nextMonth = $currentMonth->addMonth();
        $endWeek = $nextMonth->weekOfYear;
        $startWeek = $currentMonth->weekOfYear;
        $payWeek = clone $currentMonth;

        $addDays = ($startPay->dayOfWeek - $payWeek->dayOfWeek);

        if ($startPay->dayOfWeek < $payWeek->dayOfWeek) {
            $addDays = (7 - $payWeek->dayOfWeek) + $startPay->dayOfWeek;
        }

        $payWeek->addDays($addDays);
        $totalWeeks = ($payWeek->weekOfYear - $startPay->weekOfYear);

        if ($totalWeeks % 2) {
            $payWeek->addDays(7);
        }

        if ($startWeek > 52) {
            $startWeek = 1;
        }

        if ($currentMonth->format('M') === 'Dec') {
            $endWeek = 52;
        }

        for ($i = 0; $i <= ($endWeek - $startWeek); $i = ($i+2)) {
            if ($currentMonth->format('M') === $payWeek->format('M')) {
                $results[] = [
                    'id' => $job['id'],
                    'name' => $job['name'],
                    'amount' => $job['amount'],
                    'income_type_id' => $job['income_type_id'],
                    'initial_pay_date' => $payWeek->toDateTimeString(),
                    'int' => $i,
                ];
                $payWeek->addDays(14);
            }
        }

        return $results;
    }

    /**
     * Get semi-monthly pay periods for a billing cycle; called dynamically from generatePaidExpenses()
     *
     * @param array $job {
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     * @param Carbon $startPay
     * @param Carbon $currentMonth
     * @return array {
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     */
    private function get_semi_monthly($job, $startPay, $currentMonth)
    {
        $results = [];
        $dates = [
            $currentMonth->format('Y-m') . '-15 00:00:00',
            $currentMonth->endOfMonth()->toDateTimeString(),
        ];

        foreach ($dates as $date) {
            $job['initial_pay_date'] = $date;
            $results[] = $job;
        }

        return $results;
    }

    /**
     * Get monthly pay periods for a billing cycle; called dynamically from generatePaidExpenses()
     *
     * @param array $job {
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     * @param Carbon $startPay
     * @param Carbon $currentMonth
     * @return array {
     *      @value string ['name']
     *      @value string ['amount']
     *      @value integer ['income_type_id']
     *      @value Datetime ['initial_pay_date']
     * }
     */
    private function get_monthly($job, $startPay, $currentMonth)
    {
        $newPayPeriod = $startPay->addMonth();
        $date = $newPayPeriod;

        if ($newPayPeriod->format('Y-m') !== $currentMonth->format('Y-m')) {
            $day = $startPay->format('d');
            $currentCycle = $currentMonth->format('Y-m');
            $date = Carbon::createFromTimeString($currentCycle . '-' . $day . ' 00:00:00');
        }

        return [
            'id' => $job['id'],
            'name' => $job['name'],
            'amount' => $job['amount'],
            'income_type_id' => $job['income_type_id'],
            'initial_pay_date' => $date->toDateTimeString(),
        ];
    }
}

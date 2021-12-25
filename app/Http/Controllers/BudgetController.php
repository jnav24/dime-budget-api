<?php

namespace App\Http\Controllers;

use App\Models\BillType;
use App\Models\BudgetAggregation;
use App\Models\Budget;
use App\Services\IncomeService;
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
    public function store(Request $request, IncomeService $incomeService)
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

            DB::beginTransaction();
            $budget = Budget::firstOrCreate(
                ['id' => $id],
                [
                    'name' => $request->input('name'),
                    'budget_cycle' => $request->input('cycle'),
                    'user_id' => auth()->user()->id,
                ]
            );

            if (empty($id)) {
                $expenses['incomes'] = $incomeService->generatePaidExpenses($request->input('cycle'), $expenses['incomes']);
            }

            $budget->updated_at = Carbon::now()->format('Y-m-d H:i:s');
            $budget->save();
            Log::debug('Budget saved.');
            $types = BillType::all();
            $returnExpenses = $this->saveExpenses($budget->id, $expenses);
            Log::debug('Expenses saved.');
            $this->setupAndSaveAggregation(
                $budget->id,
                $expenses,
                $types->filter(function ($type) {
                    return !$type->save_type;
                })->pluck('slug')->toArray()
            );
            Log::debug('Aggregations saved.');
            $saved = $budget->aggregations->filter(function ($value, $key) {
                return $value->type === 'saved';
            });
            Log::debug('Aggregation Filter ' . json_encode($saved));

            DB::commit();
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
            DB::rollBack();
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
        $aggregate = BudgetAggregation::firstOrCreate([
            'budget_id' => $budgetId,
            'type' => $type,
            'user_id' => auth()->user()->id,
        ]);
        $aggregate->value = $total;
        $aggregate->save();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BillType;
use App\Traits\DimeUtils;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\APIResponse;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, APIResponse, DimeUtils;

    /**
     * Save all expenses; works on template expenses as well
     *
     * @param $budgetId
     * @param array $expenses {
     *      @value array {
     *          @value string ['name']
     *          @value string ['amount']
     *          @value integer ['income_type_id']
     *          @value Datetime ['initial_pay_date']
     *      }
     * }
     * @param bool $isTemplate
     * @return array $expenses
     * @var $expenses[string]array
     * @throws \Exception
     */
    protected function saveExpenses($budgetId, $expenses, $isTemplate = false)
    {
        try {
            DB::beginTransaction();

            $types = BillType::all();
            $slugs = $types->pluck('slug');

            $returnExpenses = [];

            foreach ($expenses as $key => $expenseList) {
                $index = $slugs->search($key);
                $model = 'App\\Models\\' . $types[$index]->model . (!$isTemplate ? null : 'Template');
                $id = !$isTemplate ? 'budget_id' : 'budget_template_id';

                if (class_exists($model)) {
                    $class = new $model();

                    $returnExpenses[$key] = array_map(
                        function ($expense) use ($model, $class, $budgetId, $id, $isTemplate) {
                            $expenseId = $this->isNotTempId($expense['id']) ? $expense['id'] : null;
                            $notTrack = !empty($expense['not_track_amount']) ? (int)$expense['not_track_amount'] : 0;

                            if ($class->getTable() === 'banks' &&  empty($expense['bank_template_id'])) {
                                $expense['bank_template_id'] = 0;
                            }

                            return $model::updateOrCreate(
                                ['id' => $expenseId],
                                array_merge(
                                    array_intersect_key($expense, $class->getAttributes()),
                                    [$id => $budgetId],
                                    (!$isTemplate ? ['not_track_amount' => $notTrack] : [])
                                )
                            );
                        },
                        $expenseList
                    );
                }
            }

            DB::commit();
            return $returnExpenses;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    protected function getAllRelationships($sql)
    {
        $expenses = [];
        $types = BillType::all();
        $slugs = $types->pluck('slug');

        foreach ($slugs as $slug) {
            $sql->with($this->convertSlugToSnakeCase($slug));
        }

        $data = $sql->firstOrFail();

        foreach ($slugs as $slug) {
            $snakeSlug = $this->convertSlugToSnakeCase($slug);
            $expenses[$slug] = $data->{$snakeSlug}->toArray();
        }

        return [
            'data' => $data,
            'expenses' => $expenses,
        ];
    }
}

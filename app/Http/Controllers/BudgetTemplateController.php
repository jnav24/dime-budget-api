<?php

namespace App\Http\Controllers;

use App\Models\BillType;
use App\Models\BudgetTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Http\Request;

class BudgetTemplateController extends Controller
{
    /**
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function destroy(Request $request)
    {
        try {
            if (!empty($request->all()) && is_array($request->all()[0])) {
                foreach ($request->all() as $budgetTemplate) {
                    $this->deleteCurrentBudgetTemplate($budgetTemplate);
                }
            } else {
                $this->deleteCurrentBudgetTemplate($request->all());
            }

            return $this->respondWithOK([]);
        } catch (\Exception $e) {
            Log::error('BudgetTemplateController::deleteBudgetTemplate - ' . $e->getMessage());
            return $this->respondWithBadRequest([], 'Unable to delete budget template at this time.');
        }
    }

    public function index()
    {
        try {
            $sql = BudgetTemplate::where('user_id', auth()->user()->id);
            ['data' => $data, 'expenses' => $expenses] = $this->getAllRelationships($sql);

            return $this->respondWithOK([
                'template' => [
                    'id' => $data->id,
                    'expenses' => $expenses,
                ],
            ]);
        } catch (ModelNotFoundException $e) {
            return $this->respondWithBadRequest([], 'User does not have any budget templates');
        } catch (\Exception $e) {
            Log::error('BudgetTemplate::getAllBudgetTemplates - ' . $e->getMessage());
            return $this->respondWithBadRequest([], 'Unable to retrieve budgets at this time.');
        }
    }

    /**
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function store(Request $request)
    {
        try {
            if (empty($request->input('expenses'))) {
                return $this->respondWithBadRequest([], 'Missing expenses.');
            }

            $template = BudgetTemplate::firstOrCreate([
                'user_id' => auth()->user()->id,
            ]);

            $savedData = $this->saveExpenses($template->id, $request->input('expenses'), true);

            return $this->respondWithOK([
                'templates' => [
                    'id' => $template->id,
                    'expenses' => $savedData,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('BudgetTemplateController::saveBudgetTemplates - ' . $e->getMessage());
            return $this->respondWithBadRequest([], 'Unable to save budget template at this time.');
        }
    }

    /**
     * @param $budgetTemplate
     * @return bool
     * @throws \Exception
     */
    private function deleteCurrentBudgetTemplate($budgetTemplate): bool
    {
        if (
            empty($budgetTemplate['id']) || !is_numeric($budgetTemplate['id']) ||
            empty($budgetTemplate['type']) || strlen($budgetTemplate['type']) < 3
        ) {
            throw new \Exception('Id and type are required');
        }

        $template = BudgetTemplate::where('user_id', auth()->user()->id)->first();

        if (empty($template)) {
            throw new \Exception('User does not have a template');
        }

        $type = BillType::where('slug', $budgetTemplate['type'])->firstOrFail();
        $model = 'App\\Models\\' . $type->model . 'Template';

        if (class_exists($model)) {
            $object = $model::where('id', $budgetTemplate['id'])
                ->where('budget_template_id', $template->id)
                ->first();

            if (!empty($object)) {
                $object->delete();
            }

            return true;
        }

        throw new \Exception('Model ' . $model . ' does not exist');
    }
}

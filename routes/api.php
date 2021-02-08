<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum', 'verify.session'])->group(function () {
    Route::get('budget-aggregate', [\App\Http\Controllers\BudgetAggregationController::class, 'getYearlyAggregation']);
    Route::get('current-budget-aggregate/{year}', [\App\Http\Controllers\BudgetAggregationController::class, 'getSingleYearAggregation']);
    Route::get('unpaid-aggregate', [\App\Http\Controllers\BudgetAggregationController::class, 'getCountOfUnPaidBills']);

    Route::get('budgets', [\App\Http\Controllers\BudgetController::class, 'getAllBudgets']);
    Route::get('budgets/{id}', [\App\Http\Controllers\BudgetController::class, 'getSingleBudgetExpenses']);
    Route::post('budgets', [\App\Http\Controllers\BudgetController::class, 'saveBudget']);
    Route::delete('budgets/{id}', [\App\Http\Controllers\BudgetController::class, 'deleteBudget']);
    Route::delete('budget-expense/{id}', [\App\Http\Controllers\BudgetController::class, 'deleteBudgetExpense']);

    Route::get('budget-templates', [\App\Http\Controllers\BudgetTemplateController::class, 'getAllBudgetTemplates']);
    Route::post('budget-templates', [\App\Http\Controllers\BudgetTemplateController::class, 'saveBudgetTemplates']);
    Route::delete('budget-templates', [\App\Http\Controllers\BudgetTemplateController::class, 'deleteBudgetTemplate']);

    Route::post('search', [\App\Http\Controllers\SearchController::class, 'runSearch']);

    Route::get('types/bill', [\App\Http\Controllers\TypeController::class, 'bill']);

    Route::get('user-profile', [\App\Http\Controllers\UserController::class, 'updateUserProfile']);
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\BudgetAggregationController;
use App\Http\Controllers\BudgetTemplateController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;

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
    Route::get('budget-aggregate', [BudgetAggregationController::class, 'getYearlyAggregation']);
    Route::get('current-budget-aggregate/{year}', [BudgetAggregationController::class, 'getSingleYearAggregation']);
    Route::get('unpaid-aggregate', [BudgetAggregationController::class, 'getCountOfUnPaidBills']);
    Route::resource('budgets', BudgetController::class);
    Route::delete('budget-expense/{id}', [BudgetController::class, 'deleteBudgetExpense']);
    Route::resource('budget-templates', BudgetTemplateController::class);
    Route::post('search', [SearchController::class, 'runSearch']);
    Route::get('types/bill', [TypeController::class, 'bill']);
    Route::get('user-profile', [UserController::class, 'updateUserProfile']);
});

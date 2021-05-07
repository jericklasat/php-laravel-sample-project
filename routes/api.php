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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('admin')->middleware('auth:sanctum')->group(function() {
    route::post('/transaction/create', [App\Http\Controllers\AdminController::class, 'CreateNewTransaction'])->name('transaction_create');
    route::get('/plan/list/all', [App\Http\Controllers\AdminController::class, 'ListAllPlans'])->name('plan_list_all');
    route::get('/user/list/all', [App\Http\Controllers\AdminController::class, 'ListAllUsers'])->name('user_list_all');
    route::get('/investments/monthly', [App\Http\Controllers\AdminController::class, 'MonthlyInvestments'])->name('monthly_investments');
    route::get('/investments/yearly', [App\Http\Controllers\AdminController::class, 'YearlyInvestments'])->name('yearly_investments');
    route::post('/investments/active/user-id', [App\Http\Controllers\AdminController::class, 'ActiveInvestmentByUserId'])->name('active_investments_by_user_id');
    route::post('/investments/attachment/update/id', [App\Http\Controllers\AdminController::class, 'UpdateInvestmentAttachmentById'])->name('update_investment_attachment_by_id');
    route::get('/investments/history/monthly', [App\Http\Controllers\AdminController::class, 'MonthlyInvestmentsHistory'])->name('monthly_investments_history');
    route::get('/investments/history/yearly', [App\Http\Controllers\AdminController::class, 'YearlyInvestmentsHistory'])->name('yearly_investments_history');
    route::post('/user-and-investment/update/status', [App\Http\Controllers\AdminController::class, 'UpdateUserAndInvestmentStatus'])->name('update_user_and_investment_status');
});

Route::prefix('user')->middleware('auth:sanctum')->group(function() {
    route::get('/active/details', [App\Http\Controllers\UserController::class, 'ActiveUserDetails'])->name('active_user_details');
    route::get('/active/investments', [App\Http\Controllers\UserController::class, 'ActiveUserInvestment'])->name('active_user_investments');
    route::post('/active/payouts/investment-id', [App\Http\Controllers\UserController::class, 'AllPayoutsByInvestmentId'])->name('payouts_by_investment_id');
    route::post('/active/investments/id', [App\Http\Controllers\UserController::class, 'ActiveInvestmentById'])->name('active_investments_by_id');
    route::post('/profile/update/id', [App\Http\Controllers\UserController::class, 'UpdateUserProfile'])->name('update_user_profile');
    route::post('/interest/history/investment-id', [App\Http\Controllers\UserController::class, 'AllInterestHistoryByInvestmentId'])->name('interest_history_by_investment_id');
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\AuthController as AuthControllerV1;
use App\Http\Controllers\v2\AuthController as AuthControllerV2;
use App\Http\Controllers\v1\CategoryController as CategoryControllerV1;
use App\Http\Controllers\v1\CustomerController as CustomerControllerV1;
use App\Http\Controllers\v1\ExpenseController as ExpenseControllerV1;
use App\Http\Controllers\v1\RevenueController as RevenueControllerV1;
use App\Http\Controllers\v1\SettingsController as SettingsControllerV1;
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
Route::prefix('v1')->group(function () {

    Route::get('/test', function() { return 'API Version 1.0'; });
    Route::post('/auth', [AuthControllerV1::class, 'auth']);

    /*
     * Protected routes
     */
    Route::group(['middleware' => ['apiJwt']], function (){

        /*
         * Auth+Users routes
         */
        Route::post('/auth/sso', [AuthControllerV1::class, 'sso']);
        Route::post('/users', [AuthControllerV1::class, 'store']);
        Route::get('/users/{id}', [AuthControllerV1::class, 'show']);
        Route::put('/users/{id}', [AuthControllerV1::class, 'update']);
        Route::post('/logout', [AuthControllerV1::class, 'logout']);

        /*
         * Categories routes
         */
        Route::get('/categories', [CategoryControllerV1::class, 'index']);
        Route::get('/categories/{key}={value}', [CategoryControllerV1::class, 'search']);
        Route::get('/categories/{id}', [CategoryControllerV1::class, 'show']);
        Route::put('/categories/{id}', [CategoryControllerV1::class, 'update']);
        Route::post('/categories', [CategoryControllerV1::class, 'store']);
        Route::delete('/categories/{id}', [CategoryControllerV1::class, 'destroy']);

        /*
         * Customers routes
         */
        Route::get('/customers', [CustomerControllerV1::class, 'index']);
        Route::get('/customers/{key}={value}', [CustomerControllerV1::class, 'search']);
        Route::get('/customers/{id}', [CustomerControllerV1::class, 'show']);
        Route::put('/customers/{id}', [CustomerControllerV1::class, 'update']);
        Route::post('/customers', [CustomerControllerV1::class, 'store']);
        Route::delete('/customers/{id}', [CustomerControllerV1::class, 'destroy']);

        /*
         * Expenses routes
         */
        Route::get('/expenses', [ExpenseControllerV1::class, 'index']);
        Route::put('/expenses/{id}', [ExpenseControllerV1::class, 'update']);
        Route::post('/expenses', [ExpenseControllerV1::class, 'store']);
        Route::delete('/expenses/{id}', [ExpenseControllerV1::class, 'destroy']);

        /*
         * Revenues routes
         */
        Route::get('/revenues', [RevenueControllerV1::class, 'index']);

        Route::post('/revenues/{customer_id}', [RevenueControllerV1::class, 'store']);
        Route::put('/revenues/{revenue_id}', [RevenueControllerV1::class, 'update']);
        Route::delete('/revenues/{revenue_id}', [RevenueControllerV1::class, 'destroy']);
        Route::post('/reports/total-revenue', [RevenueControllerV1::class, 'totalRevenue']);
        Route::post('/reports/revenue-by-month', [RevenueControllerV1::class, 'revenueByMonth']);
        Route::post('/reports/revenue-by-customer', [RevenueControllerV1::class, 'revenueByCustomer']);

        /*
         * Settings routes
         */
        Route::get('/settings', [SettingsControllerV1::class, 'index']);
        Route::post('/settings', [SettingsControllerV1::class, 'store']);
        Route::put('/settings', [SettingsControllerV1::class, 'update']);

    });

});

Route::prefix('v2')->group(function () {

    Route::get('/test', function() { return 'API Version 2.0'; });
    Route::post('/auth', [AuthControllerV2::class, 'auth']);

    Route::group(['middleware' => ['apiJwt']], function (){

        Route::post('/logout', [AuthControllerV2::class, 'logout']);

    });

});

Route::get('/', function (Request $request){
    return response()->json(['api' => 'vibbra']);
});

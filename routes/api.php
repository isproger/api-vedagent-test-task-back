<?php

use App\Http\Controllers\CalculationController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\TransportCompanyController;
use Illuminate\Support\Facades\Route;

Route::get('v1/get-transport-companies', [TransportCompanyController::class, 'getList']);
Route::get('v1/get-product-types', [ProductTypeController::class, 'getList']);
Route::post('v1/get-calculate-result', [CalculationController::class, 'getCalculateResult']);
Route::post('v1/save-calculation', [CalculationController::class, 'saveCalculation']);
Route::get('v1/get-calculation-list', [CalculationController::class, 'getList']);


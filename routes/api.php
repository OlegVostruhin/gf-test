<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\TariffController;
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

Route::get('/tariffs',[TariffController::class, 'getTariffList']);
Route::get('/tariffs/availabledates/{id}', [TariffController::class, 'getTariffAvailableDates']);
Route::post('/order', [OrderController::class, 'create']);

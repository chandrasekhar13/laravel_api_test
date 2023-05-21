<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});
Route::get('/transaction-after-balance', [TransactionController::class, 'getTransactionAfterBalance']);
Route::get('/average-balance', [TransactionController::class, 'calcAvgBalance']);
Route::get('/first-last-average-balance', [TransactionController::class, 'firstLastAvgBalance']);
Route::get('/other-conditions', [TransactionController::class, 'otherConditions']);

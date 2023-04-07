<?php

use App\Http\Controllers\MpesaController;
use App\Http\Controllers\MpesaResponseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('validation', [MpesaResponseController::class, 'validation']);
Route::post('confirmation', [MpesaResponseController::class, 'confirmation']);
Route::post('b2cCallback', [MpesaResponseController::class, 'b2cCallback']);

Route::post('stkpush', [MPESAResponsesController::class, 'stkPush']);
Route::post('transaction-status/result', [MpesaResponseController::class, 'transactionstatusresponse']);
Route::post('reversal/result_url', [MpesaResponseController::class, 'transactionsReversal']);

//Route::post('transaction-status', [MpesaResponseController::class, 'queue']);


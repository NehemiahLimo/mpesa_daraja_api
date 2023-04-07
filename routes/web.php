<?php

use App\Http\Controllers\MpesaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('get-access-token',[MpesaController::class,'chukuaToken']);

Route::post('register-urls',[MpesaController::class,'registerURL']); //getToken
Route::post('simulate',[MpesaController::class,'simulateTransaction']); //getToken
Route::post('simulateb2c',[MpesaController::class,'b2cRequest']); //getToken

Route::post('check-status',[MpesaController::class,'transactionstatus']); //getToken
Route::post('reverse-trans',[MpesaController::class,'reverseTrans']); //getToken
Route::post('stkpush', [MPESAController::class, 'stkPush']);


Route::get('b2c', function(){
    return view('b2c');
});


Route::get('trans', function(){
    return view('transaction');
});

Route::get('reverser', function(){
    return view('reverser');
});
Route::get('stk', function(){
    return view('stk');
});


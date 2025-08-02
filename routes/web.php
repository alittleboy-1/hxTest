<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Frist;
use App\Http\Middleware\EnsureTokenIsValid;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([Frist::class])->group(function () {
    // 需要验证的路由
    // Route::get('/home', [Controller::class, 'index']);
    Route::get('/list', [App\Http\Controllers\CustomerController::class, 'list']);
    Route::post('/create', [App\Http\Controllers\CustomerController::class, 'create']);
    Route::get('/get', [App\Http\Controllers\CustomerController::class, 'get']);
    Route::put('/update', [App\Http\Controllers\CustomerController::class, 'update']);
    Route::delete('/delete', [App\Http\Controllers\CustomerController::class, 'delete']);
    Route::get('/send', [App\Http\Controllers\CustomerController::class, 'send']);
});

 

 



Route::any('login', [App\Http\Controllers\CustomerController::class, 'login']);
 

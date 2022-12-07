<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\UserCheck;
use App\Http\Middleware\AdminCheck;

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


// Route::post('register', 'UserController@register');
// Route::post('login', 'UserController@login');


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    //public routes
    Route::post('logout', [UserController::class, 'logout']);
    Route::resource('ticket', AdminController::class, ['only' => ['index']]);
    Route::resource('transaction', TransactionController::class, ['only' => ['index']]);
    
    Route::middleware([UserCheck::class])->group(function () {
        Route::resource('transaction', TransactionController::class, ['only' => ['store']]);
    });

    Route::middleware([AdminCheck::class])->group(function () {
        Route::resource('ticket', AdminController::class, ['only' => [ 'store', 'update', 'destroy', 'show']]);     
        Route::resource('transaction', TransactionController::class, ['only' => [ 'update', 'destroy', 'show', 'index']]);     
    });



});



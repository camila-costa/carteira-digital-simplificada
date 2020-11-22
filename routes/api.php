<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API

// Users
Route::resource('users', UserController::class, ['except' => ['create', 'edit']]);
Route::get('users/{id}/wallets', [WalletController::class, 'indexFromUser']);

// Wallets
Route::resource('wallets', WalletController::class, ['except' => ['create', 'edit', 'store', 'destroy']]);

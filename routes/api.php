<?php

use App\Http\Controllers\v1\CompanyController;
use App\Http\Controllers\v1\UserController;
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
Route::prefix('user')->controller(UserController::class)->group(function () {
    Route::post('register', 'registration');
    Route::post('login', 'login');
});

Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('companies', [CompanyController::class, 'index']);
    Route::get('companies/{id}', [CompanyController::class, 'show']);
    Route::post('companies', [CompanyController::class, 'store']);
    Route::put('companies/{id}', [CompanyController::class, 'edit']);
    Route::delete('companies/{id}', [CompanyController::class, 'destroy']);

    Route::post('logout', [UserController::class, 'logout']);
});

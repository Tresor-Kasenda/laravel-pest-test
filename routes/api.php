<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Users\DeleteUserController;
use App\Http\Controllers\Api\Users\EditUserController;
use App\Http\Controllers\Api\Users\ListeUsersController;
use App\Http\Controllers\Api\Users\StoreUsersController;
use App\Http\Controllers\Api\Users\UpdateUsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', fn (Request $request) => $request->user());


Route::get('users', ListeUsersController::class)->middleware('auth');
Route::get('users/{id}', EditUserController::class)->middleware('auth');
Route::put('users/{id}', UpdateUsersController::class)->middleware('auth');
Route::post('users', StoreUsersController::class)->middleware('auth');
Route::delete('users/{id}', DeleteUserController::class)->middleware('auth');

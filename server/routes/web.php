<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\userController;
use App\Http\Controllers\bookController;
use App\Http\Controllers\rateController;

Route::group(['prefix' => 'user'], function () {
    Route::post('/login', [userController::class, 'login']);
    Route::post('/register', [userController::class, 'register']);
});

Route::group(['prefix' => 'book'], function () {
    Route::get('/{field?}', [bookController::class, 'index']);
    Route::post('/create', [bookController::class, 'create']);
    Route::get('/show/{id}', [bookController::class, 'show']);
    Route::post('/edit/{id}', [bookController::class, 'edit']);
    Route::delete('/destroy/{id}', [bookController::class, 'destroy']);
});

Route::group(['prefix' => 'rate'], function () {
    Route::get('/', [rateController::class, 'index']);
    Route::post('/create', [rateController::class, 'create']);
    Route::get('/show/{id}', [rateController::class, 'show']);
    Route::post('/edit', [rateController::class, 'edit']);
    Route::delete('/destroy/{id_user}/{id_book}', [rateController::class, 'destroy']);
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\bookController;
use App\Http\Controllers\rateController;

Route::group(['middleware' => 'cors', 'prefix' => 'user'], function () {
    Route::post('/login', [userController::class, 'login']);
    Route::post('/register', [userController::class, 'register']);
});

Route::group(['middleware' => 'cors', 'prefix' => 'book'], function () {
    Route::get('/', [bookController::class, 'index']);
    Route::post('/create', [bookController::class, 'create']);
    Route::get('/show/{id}', [bookController::class, 'show']);
    Route::get('/show/my/{id}', [bookController::class, 'showMyBooks']);
    Route::post('/edit/{id}', [bookController::class, 'edit']);
    Route::post('/destroy', [bookController::class, 'destroy']);
});

Route::group(['middleware' => 'cors', 'prefix' => 'rate'], function () {
    Route::post('/create', [rateController::class, 'create']);
    Route::get('/show/{id}', [rateController::class, 'show']);
    Route::post('/edit', [rateController::class, 'edit']);
    Route::post('/destroy', [rateController::class, 'destroy']);
});
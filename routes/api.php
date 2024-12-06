<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post(
    '/register',
    [
        \App\Http\Controllers\Api\AuthController::class,
        'register'
    ]
);
Route::post(
    '/login',
    [\App\Http\Controllers\Api\AuthController::class, 'login']
);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    );
    Route::resource(
        '/mahasiswa',
        \App\Http\Controllers\Api\MahasiswaController::class,
    );
    Route::resource(
        '/dosen',
        \App\Http\Controllers\Api\DosenController::class,
    );
    Route::resource(
        '/makul',
        \App\Http\Controllers\Api\MakulController::class,
    );
});

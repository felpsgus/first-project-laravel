<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "Api" middleware group. Make something great!
|
*/

Route::get(
    '/v1/',
    [\App\Http\Controllers\Api\V1\EnderecosController::class, 'showAll']
);

Route::get(
    '/v1/{value}',
    [\App\Http\Controllers\Api\V1\EnderecosController::class, 'show']
);

Route::post(
    '/v1/',
    [\App\Http\Controllers\Api\V1\EnderecosController::class, 'save']
);

Route::patch(
    '/v1/{id}',
    [\App\Http\Controllers\Api\V1\EnderecosController::class, 'update']
);

Route::delete(
    '/v1/{id}',
    [\App\Http\Controllers\Api\V1\EnderecosController::class, 'destroy']
);

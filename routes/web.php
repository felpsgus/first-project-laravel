<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdressController;
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

Route::get('/', [AdressController::class, "index"])->name('home');

Route::get('/search', [AdressController::class, "search"])->name('search');

Route::post('/save', [AdressController::class, "save"])->name('save');

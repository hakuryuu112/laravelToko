<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Auth Controller
Route::get('/auth', [AuthController::class, 'auth']);

//Product Conroller
Route::get('/product', [ProductController::class, 'findAll']);
Route::get('/product/{product}', [ProductController::class, 'findOne']);

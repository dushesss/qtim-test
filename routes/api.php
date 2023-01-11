<?php

use App\Http\Controllers\PostConroller;
use App\Http\Controllers\UsersController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UsersController::class, "register"])->name('auth.registration');

Route::post('/login', [UsersController::class, "login"])->name('login');


Route::middleware('auth:api')->group( function () {
    Route::post('/posts/all', [PostConroller::class, "index"]);
});

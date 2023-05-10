<?php

use App\Http\Controllers\User\UserController;
use \App\Http\Controllers\Auth\AuthController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(function() {
    Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function() {
    Route::post('user/create', [UserController::class, 'createUser']);
    Route::post('auth/logout', [AuthController::class, 'logout']);

    Route::post('book/create', [\App\Http\Controllers\Book\BookController::class, 'createBook']);
    Route::post('book/delete', [\App\Http\Controllers\Book\BookController::class, 'deleteBook']);

    Route::post('category/create', [\App\Http\Controllers\Category\CategoryController::class, 'createCategory']);
    Route::post('category/delete', [\App\Http\Controllers\Category\CategoryController::class, 'deleteCategory']);

});

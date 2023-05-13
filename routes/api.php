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
    Route::post('user/create', [UserController::class, 'createUser'])->name('user.createUser');
    Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::post('book/create', [\App\Http\Controllers\Book\BookController::class, 'createBook'])->name('book.createBook');
    Route::post('book/delete', [\App\Http\Controllers\Book\BookController::class, 'deleteBook'])->name('book.deleteBook');
    Route::post('book/add-category', [\App\Http\Controllers\Book\BookController::class, 'addBookToCategory'])->name('book.addBookToCategory');
    Route::post('book/remove-category', [\App\Http\Controllers\Book\BookController::class, 'removeBookFromCategory'])->name('book.removeBookFromCategory');
    Route::post('book/add-comment', [\App\Http\Controllers\Book\BookController::class, 'addComment'])->name('book.addComment');
    Route::get('book/get-comments', [\App\Http\Controllers\Book\BookController::class, 'getAllComments'])->name('book.getAllComments');
    Route::get('book/find', [\App\Http\Controllers\Book\BookController::class, 'findBooks'])->name('book.findBooks');


    Route::post('category/create', [\App\Http\Controllers\Category\CategoryController::class, 'createCategory'])->name('category.createCategory');
    Route::post('category/delete', [\App\Http\Controllers\Category\CategoryController::class, 'deleteCategory'])->name('category.deleteCategory');

    Route::post('file/upload', [\App\Http\Controllers\File\FileController::class, 'upload'])->name('file.upload');
    Route::get('file/download', [\App\Http\Controllers\File\FileController::class, 'download'])->name('file.download');

    Route::post('command/update-code', [\App\Http\Controllers\Command\CommandController::class, 'updateCode'])->name('command.updateCode');

    Route::get('permission/get-all-route', [\App\Http\Controllers\Permission\PermissionController::class, 'getAllRoute'])->name('permission.getAllRoute');
    Route::post('permission/disable-routes', [\App\Http\Controllers\Permission\PermissionController::class, 'disableRoutes'])->name('permission.disableRoutes');
    Route::post('permission/enable-routes', [\App\Http\Controllers\Permission\PermissionController::class, 'enableRoutes'])->name('permission.enableRoutes');
    Route::get('permission/get-role-info', [\App\Http\Controllers\Permission\PermissionController::class, 'getRoleInfo'])->name('permission.getRoleInfo');


});

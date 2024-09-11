<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QiuzController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('auth.login');
});

// Auth::routes();
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::group([
    'middleware' => 'auth:sanctum'
], function() {
    Route::group([
        'middleware' => AdminMiddleware::class
    ], function() {
        //Dashboard
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        //Category
        Route::get('/category/index', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/category/create', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/{category}/delete', [CategoryController::class, 'destroy'])->name('category.destroy');
        //Qiuz for not for all
        Route::get('/quiz', [QiuzController::class, 'index'])->name('quiz');
        Route::get('/quiz/create', [QiuzController::class, 'create'])->name('quiz.create');
        Route::post('/quiz/create', [QiuzController::class, 'store'])->name('quiz.store');
        Route::get('/quiz/{quiz}/edit', [QiuzController::class, 'edit'])->name('quiz.edit');
        Route::put('/quiz/{quiz}', [QiuzController::class, 'update'])->name('quiz.update');
        Route::delete('/quiz/{quiz}/delete', [QiuzController::class, 'destroy'])->name('quiz.destroy');

    });

});

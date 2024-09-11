<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\WhishlistController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FavouriteController;

//auth
Route::post('/user/login',[AuthController::class,'login']);
Route::get('/user/myself', [AuthController::class, 'myself'])->middleware('auth:sanctum');
Route::put('/user/update/{id}', [AuthController::class, 'update'])->middleware('auth:sanctum');
Route::post('/user/register',[AuthController::class,'register']);
Route::post('/user/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//user
Route::get('/user',[AuthController::class,'index']);
Route::get('/user/{id}',[AuthController::class,'show']);
Route::put('/user/{id}/update',[AuthController::class,'update']);
Route::delete('/user/delete/{id}',[AuthController::class,'delete']);

//Category
Route::get('/category',[CategoryController::class,'index']);
Route::get('/category/category={id}',[CategoryController::class,'show']);
Route::post('/category/store',[CategoryController::class,'store']);
Route::put('/category/update/{id}',[CategoryController::class,'update']);
Route::delete('/category/delete/{id}',[CategoryController::class,'destroy']);
Route::get('/category/search',[CategoryController::class,'search']);

// Quiz
Route::get('/quiz',[QuizController::class,'index']);
Route::get('/quiz/{id}',[QuizController::class,'show']);
Route::post('/quiz/store',[QuizController::class,'store']);
Route::put('/quiz/update/{id}',[QuizController::class,'update']);
Route::delete('/quiz/delete/{id}',[QuizController::class,'destroy']);


Route::group([
    'middleware' => 'auth:sanctum'
], function() {

    Route::get('/cart', [WhishlistController::class, 'index']);
    Route::post('/cart/store', [WhishlistController::class, 'store']);
    Route::delete('/cart/delete/{id}', [WhishlistController::class, 'destroy']);
    Route::get('/scores', [ScoreController::class, 'index']);
    Route::post('/scores/store', [ScoreController::class, 'store']);
    Route::delete('/scores/delete/{id}', [ScoreController::class, 'destroy']);
});


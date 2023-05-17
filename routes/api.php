<?php

use App\Http\Controllers\Api\CarouselItemsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MessagesController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AiController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Public APIs
Route::controller(AuthController::class)->group(function () {
    Route::post('/login', [AuthController::class,'login'])->name('user.login');
    Route::post('/user',  [UserController::class,'store'])->name('user.store');
  
    //OCR API
    Route::post('/ocr', [AiController::class,'ocr'])->name('ocr.image');
});




//Private(ADMIN API's) APIs
Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [AuthController::class,'logout']);
//CarouselITems
    Route::controller(CarouselItemsController::class)->group(function () {
        Route::get('/carousel',                 'index');
        Route::get('/carousel/{id}',            'show');
        Route::post('/carousel',                'store');
        Route::delete('/carousel/{id}',         'destroy');
        Route::put('/carousel/{id}',            'update');
        });

//UserController 
    Route::controller(UserController::class)->group(function () {
        Route::get('/user',                     'index');
        Route::get('/user/{id}',                'show');
        Route::put('/user/{id}',                'update')->name('user.update');
        Route::put('/user/email/{id}',          'email')->name('user.email');
        Route::put('/user/password/{id}',       'password')->name('user.password');
        Route::put('/user/image/{id}',       'image')->name('user.image');
        Route::delete('/user/{id}',             'destroy');


    });

//User Specific Profile
Route::get('/profile/show',       [ProfileController::class,'show']);
Route::put('/profile/image',       [ProfileController::class,'image'])->name('profile.image');


});


//Messages
Route::get('/messages', [MessagesController::class, 'index']);
Route::delete('/messages/{id}', [MessagesController::class, 'destroy']);
Route::post('/messages', [MessagesController::class, 'store']);
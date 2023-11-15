<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Authorization\AuthorizationController;
use App\Http\Controllers\Authorization\VerifyController;
use App\Http\Controllers\Comments\CommentsController;
use App\Http\Controllers\Media\AudioController;
use App\Http\Controllers\Media\PhotoController;
use App\Http\Controllers\Media\VideoController;
use App\Http\Controllers\News\NewsController;
use App\Http\Controllers\Nurseries\NurseriesController;
use App\Http\Controllers\Peculiarities\PeculiaritiesController;
use App\Http\Controllers\PersonalArea\PersonalAreaController;
use Illuminate\Support\Facades\Route;

// leorlik@ya.ru
// leorlik_2@ya.ru
// Pristxolidc2013
Route::get('/account/verify', [VerifyController::class, 'verify'])->name('verification.verify');
Route::post('/account/registration', [AuthorizationController::class, 'registration']);
Route::post('/account/login', [AuthorizationController::class, 'login']);
Route::post('/account/logout', [AuthorizationController::class, 'logout']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/account/me', [PersonalAreaController::class, 'me']);
    Route::post('/account/update', [PersonalAreaController::class, 'update']);
    Route::post('/account/feedback', [PersonalAreaController::class, 'feedback']);
    Route::prefix('/admin')->middleware(['verified', 'admin'])->group(function () {
        Route::get('users', [AdminController::class, 'index']);
        Route::get('user/edit/{user}', [AdminController::class, 'edit']);
        Route::post('user/update/{user}', [AdminController::class, 'update']);
        Route::post('user/banned/{user}', [AdminController::class, 'banned']);
    });
});

Route::prefix('/peculiarities')->group(function (){
    Route::get('/', [PeculiaritiesController::class, 'peculiarities']);
    Route::get('/care', [PeculiaritiesController::class, 'care']);
    Route::get('/nutrition', [PeculiaritiesController::class, 'nutrition']);
    Route::get('/health', [PeculiaritiesController::class, 'health']);
    Route::get('/paddock', [PeculiaritiesController::class, 'paddock']);
});
Route::prefix('/nurseries')->group(function (){
    Route::get('/', [NurseriesController::class, 'index']);
});
Route::prefix('/news')->group(function (){
    Route::get('/', [NewsController::class, 'index']);
    Route::get('/show', [NewsController::class, 'show']);
});
Route::prefix('/comments')->group(function (){
    Route::get('/{news}/{page?}/{parent_comment?}', [CommentsController::class, 'index']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/store', [CommentsController::class, 'store']);
        Route::post('/delete/{comment}', [CommentsController::class, 'destroy']);
    });
});
Route::prefix('/media')->group(function (){
    Route::prefix('/photo')->group(function (){
        Route::get('/{page?}', [PhotoController::class, 'index']);
        Route::post('/store', [PhotoController::class, 'store']);
        Route::patch('/update/{photo}', [PhotoController::class, 'update']);
        Route::delete('/delete/{photo}', [PhotoController::class, 'destroy']);
    });
    Route::prefix('/video')->group(function (){
        Route::get('/{page?}', [VideoController::class, 'index']);
        Route::post('/store', [VideoController::class, 'store']);
        Route::patch('/update/{video}', [VideoController::class, 'update']);
        Route::delete('/delete/{video}', [VideoController::class, 'destroy']);
    });
    Route::prefix('/audio')->group(function (){
        Route::get('/{page?}', [AudioController::class, 'index']);
        Route::post('/store', [AudioController::class, 'store']);
        Route::patch('/update/{audio}', [AudioController::class, 'update']);
        Route::delete('/delete/{audio}', [AudioController::class, 'destroy']);
    });
    Route::get('/{news}/{parent_comment?}/{page?}', [CommentsController::class, 'index']);
});

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/protected', function (){
        return response()->json(['protected' => 'true']);
    });
});

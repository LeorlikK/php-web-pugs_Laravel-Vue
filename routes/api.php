<?php

use App\Http\Controllers\Authorization\AuthorizationController;
use App\Http\Controllers\Comments\CommentsController;
use App\Http\Controllers\Media\PhotoController;
use App\Http\Controllers\News\NewsController;
use App\Http\Controllers\Nurseries\NurseriesController;
use App\Http\Controllers\Peculiarities\PeculiaritiesController;
use App\Models\Audio;
use App\Models\Video;
use Illuminate\Support\Facades\Route;

// leorlik@ya.ru
// leorlik_2@ya.ru
// Pristxolidc2013
Route::post('/account/registration', [AuthorizationController::class, 'registration']);
Route::post('/account/login', [AuthorizationController::class, 'login']);
Route::post('/account/logout', [AuthorizationController::class, 'logout']);

Route::prefix('/peculiarities')->group(function (){
    Route::get('/', [PeculiaritiesController::class, 'peculiarities']);
    Route::get('/care', [PeculiaritiesController::class, 'care']);
    Route::get('/nutrition', [PeculiaritiesController::class, 'nutrition']);
    Route::get('/health', [PeculiaritiesController::class, 'health']);
    Route::get('/paddock', [PeculiaritiesController::class, 'paddock']);
});
Route::prefix('/nurseries')->group(function (){
    Route::get('/{page?}', [NurseriesController::class, 'index']);
});
Route::prefix('/news')->group(function (){
    Route::get('/', [NewsController::class, 'index']);
    Route::get('/show/{news}', [NewsController::class, 'show']);
});
Route::prefix('/comments')->group(function (){
    Route::get('/{news}/{parent_comment?}/{page?}', [CommentsController::class, 'index']);
});
Route::prefix('/media')->group(function (){
    Route::prefix('/photo')->group(function (){
        Route::get('/{page}', [PhotoController::class, 'index']);
        Route::post('/store', [PhotoController::class, 'store']);
        Route::patch('/update/{photo}', [PhotoController::class, 'update']);
        Route::delete('/delete/{photo}', [PhotoController::class, 'destroy']);
    });
    Route::prefix('/video')->group(function (){
        Route::get('/{page}', [Video::class, 'index']);
        Route::post('/store', [Video::class, 'store']);
        Route::patch('/update/{video}', [Video::class, 'update']);
        Route::delete('/delete/{video}', [Video::class, 'destroy']);
    });
    Route::prefix('/audio')->group(function (){
        Route::get('/{page}', [Audio::class, 'index']);
        Route::post('/store', [Audio::class, 'store']);
        Route::patch('/update/{audio}', [Audio::class, 'update']);
        Route::delete('/delete/{audio}', [Audio::class, 'destroy']);
    });
    Route::get('/{news}/{parent_comment?}/{page?}', [CommentsController::class, 'index']);
});
Route::prefix('/css')->group(function (){
    Route::get('/', []);
});

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/protected', function (){
        return response()->json(['protected' => 'true']);
    });
});

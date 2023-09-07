<?php

use App\Http\Controllers\Authorization\AuthorizationController;
use App\Http\Controllers\Comments\CommentsController;
use App\Http\Controllers\News\NewsController;
use App\Http\Controllers\Nurseries\NurseriesController;
use App\Http\Controllers\Peculiarities\PeculiaritiesController;
use Illuminate\Support\Facades\Route;

// leorlik@ya.ru
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
    Route::get('/{page?}', [NewsController::class, 'index']);
    Route::get('/show/{news}', [NewsController::class, 'show']);
});
Route::prefix('/comments')->group(function (){
    Route::get('/{news}/{parent_comment?}/{page?}', [CommentsController::class, 'index']);
});
Route::middleware('auth:sanctum')->group(function (){
    Route::get('/protected', function (){
        return response()->json(['protected' => 'true']);
    });
});

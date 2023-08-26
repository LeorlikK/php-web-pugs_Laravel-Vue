<?php

use App\Http\Controllers\Authorization\AuthorizationController;
use App\Http\Controllers\Peculiarities\PeculiaritiesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
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
Route::middleware('auth:sanctum')->group(function (){
    Route::get('/protected', function (){
        return response()->json(['protected' => 'true']);
    });
});

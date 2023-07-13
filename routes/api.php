<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;
use Illuminate\Support\Facades\Artisan;

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


Route::prefix('v1')->group(function () {
    /**
     * @unauthenticated
     */
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });

    Route::middleware('auth:api')->group(function () {
        Route::get('user', function (Request $request) {
            return $request->user();
        });
        Route::get('users', [AuthController::class, 'getUsers']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::prefix('chat')->group(function () {
            Route::post('widget', [ChatController::class, 'chatWidget']);
            Route::post('send', [ChatController::class, 'sendMessage']);
            Route::post('delete', [ChatController::class, 'deleteMessage']);
        });
    });




    // Route::post('clear-db' , function(){
    //     Artisan::call('migrate:fresh --seed');
    //     return 'Database Cleared';
    // });
});

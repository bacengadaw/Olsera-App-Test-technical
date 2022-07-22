<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\PajakController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'namespace' => 'Api'
], function () {

    // item 
    Route::prefix('item')->group(function() {
        Route::get('/list-item', [ItemController::class, 'index']);
        Route::post('/create-data-item', [ItemController::class, 'create']);
        Route::put('/update-data-item/{id}', [ItemController::class, 'update']);
        Route::post('/delete-data-item/{id}', [ItemController::class, 'destroy']);
    });
    
    // pajak 
    Route::prefix('pajak')->group(function() {
        Route::get('/list-pajak', [PajakController::class, 'index']);
        Route::post('/create-data-pajak', [PajakController::class, 'create']);
        Route::put('/update-data-pajak/{id}', [PajakController::class, 'update']);
        Route::post('/delete-data-pajak/{id}', [PajakController::class, 'destroy']);
    });

});
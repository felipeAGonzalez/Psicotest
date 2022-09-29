<?php

use App\Http\Controllers\UserController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([
    'prefix' => 'user',
], function ($router) {
    Route::group(['middleware' => ['isRoot']], function () {
        Route::put('{id}/root', [UserController::class, 'updateRoot']);
    });
    Route::delete('/{id}', [UserController::class, 'delete']);
    Route::get('/', [UserController::class, 'list']);
    Route::post('/', [UserController::class, 'register']);
    Route::put('{id}/status', [UserController::class, 'status']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::get('/{id}', [UserController::class, 'show']);
});

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

Route::group(['middleware' => ['jsononly']], function () {
    Route::get('/', function () {
        return response()->json([
            'message' => 'Welcome to innoqode assessment api.',
        ], 200);
    });
    
    Route::post('/user', [UserController::class, 'storeUser'])->middleware(['user.existing_username']);

    Route::get('/user', [UserController::class, 'getUsers']);

    Route::get('/user/{id}', [UserController::class, 'getUser'])->middleware(['user.non_existent']);

    Route::patch(
        '/user/{id}',
        [UserController::class, 'updateUser']
    )->middleware(['user.non_existent', 'user.taken_username']);

    Route::delete('/user/{id}', [UserController::class, 'destroyUser'])->middleware(['user.non_existent']);

    Route::any('{any}', function () {
        return response()->json([
            'message' => 'Not Found.',
            'errors' => [
                'route' => 'Route not found.'
            ]
        ], 404);
    });
});

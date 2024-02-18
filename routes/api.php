<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\AuthenticationController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ImageController;
use App\Http\Controllers\Api\V1\ItemController;
use App\Http\Controllers\Api\V1\RestaurantController;
use App\Http\Controllers\Api\V1\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::controller(AuthenticationController::class)->group(function () {
        Route::post('/sign-in', 'signIn');
        Route::post('/sign-out', 'signOut')->middleware(['auth:sanctum', 'ability:admin,customer']);
    });

    Route::apiResource('users', UserController::class)->middleware(['auth:sanctum', 'ability:admin']);

    Route::controller(RestaurantController::class)->group(function () {
        Route::get('/restaurants', 'index');
        Route::get('/restaurants/{restaurant}', 'show');
        Route::post('/restaurants', 'store')->middleware(['auth:sanctum', 'ability:admin,customer']);
        Route::put('/restaurants/{restaurant}', 'update')->middleware(['auth:sanctum', 'ability:admin,customer']);
        Route::patch('/restaurants/{restaurant}', 'update')->middleware(['auth:sanctum', 'ability:admin,customer']);
        Route::delete('/restaurants/{restaurant}', 'destroy')->middleware(['auth:sanctum', 'ability:admin,customer']);
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index');
        Route::get('/categories/{category}', 'show');
        Route::post('/categories', 'store')->middleware(['auth:sanctum', 'ability:admin,customer']);
        Route::put('/categories/{category}', 'update')->middleware(['auth:sanctum', 'ability:admin,customer']);
        Route::patch('/categories/{category}', 'update')->middleware(['auth:sanctum', 'ability:admin,customer']);
        Route::delete('/categories/{category}', 'destroy')->middleware(['auth:sanctum', 'ability:admin,customer']);
    });

    Route::controller(ItemController::class)->group(function () {
        Route::get('/items', 'index');
        Route::get('/items/{item}', 'show');
        Route::post('/items', 'store')->middleware(['auth:sanctum', 'ability:admin,customer']);
        Route::put('/items/{item}', 'update')->middleware(['auth:sanctum', 'ability:admin,customer']);
        Route::patch('/items/{item}', 'update')->middleware(['auth:sanctum', 'ability:admin,customer']);
        Route::delete('/items/{item}', 'destroy')->middleware(['auth:sanctum', 'ability:admin,customer']);
    });

    Route::apiResource('images', ImageController::class)->middleware(['auth:sanctum', 'ability:admin,customer']);
});

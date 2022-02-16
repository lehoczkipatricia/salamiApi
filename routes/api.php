<?php

use App\Http\Controllers\IngredientsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AuthController;
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
Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::post('/logout', [AuthController::class, "signOut"]);

    Route::post('/products', [ProductsController::class, 'create']);
    Route::put('/products/{product}', [ProductsController::class, 'update']);
    Route::delete('/products/{product}', [ProductsController::class, 'delete']);

    Route::post('/materials', [MaterialsController::class, 'create']);
    Route::put('/materials/{material}', [MaterialsController::class, 'update']);
    Route::delete('/materials/{material}', [MaterialsController::class, 'delete']);
});
Route::post('/login', [AuthController::class, "signIn"]);
Route::post('/register', [AuthController::class, "signUp"]);

Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/{product}', [ProductsController::class, 'show']);

Route::get('/materials', [MaterialsController::class, 'index']);
Route::get('/materials/{material}', [MaterialsController::class, 'show']);


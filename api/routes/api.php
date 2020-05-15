<?php

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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

// Product routes
Route::prefix('products')->group(function () {
    $controller = 'ProductsController';
    Route::get('/', "$controller@index");
    Route::get('/{product}', "$controller@show");
    Route::post('/', "$controller@store");
    Route::put('/{product}', "$controller@update");
    Route::delete('/{product}', "$controller@delete");
});

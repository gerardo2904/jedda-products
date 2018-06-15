<?php

use Illuminate\Http\Request;

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

Route::get('/{id}/products','ProductionOrderController@byProduction');
Route::get('/{id}/{largo}/{ancho}/products2','ProductionOrderController@byMateria');

Route::get('/{id}/products3','ProductionOrderController@byLeader1');
Route::get('/{id}/products4','ProductionOrderController@byLeader2');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

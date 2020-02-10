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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login','userController@login');
Route::post('register','userController@store');
Route::post('recuperarContrasena','userController@recoverPassword');

Route::group(['middleware' => ['auth']], function (){
	Route::apiResource('application','applicationController');
	Route::apiResource('restriction','restrictionController');
	Route::apiResource('usage','usageController');
	Route::get('mostrar','usageController@show');
	Route::get('mostrarLocation','usageController@map');
	Route::apiResource('user','userController');
	Route::post('updateUser','userController@update');
	Route::get('showUser','userController@show');
});


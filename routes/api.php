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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

//registro de poblacion
Route::resource('poblacion', 'PoblacionController');
Route::get('get_poblacion/{id}', 'PoblacionController@get_poblacion')->middleware('auth:api');

//ubicaciones geograficas
Route::get('/departamento', 'UbicacionGeograficaController@get_departamento');
Route::get('/municipio/{id}', 'UbicacionGeograficaController@get_municipio');

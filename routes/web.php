<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/sucursales', 'SucursalController@sucursales')->name('sucursales');
    Route::get('/obtener_sucursales', 'SucursalController@obtener_sucursales')->name('obtener_sucursales');
    Route::post('/sucursales_guardar', 'SucursalController@sucursales_guardar')->name('sucursales_guardar');
    Route::post('/sucursales_modificar', 'SucursalController@sucursales_modificar')->name('sucursales_modificar');
    Route::get('/sucursales_obtener_comics', 'SucursalController@sucursales_obtener_comics')->name('sucursales_obtener_comics');
    Route::post('/existencias_sucursal', 'SucursalController@existencias_sucursal')->name('existencias_sucursal');
    //////////////////////////////////////COMIC CONTROLLER///////////////////////////////////////////////
    Route::get('/comics', 'ComicController@comics')->name('comics');
    Route::get('/obtener_comics', 'ComicController@obtener_comics')->name('obtener_comics');
    Route::get('/obtener_datos_comic', 'ComicController@obtener_datos_comic')->name('obtener_datos_comic');
    Route::get('/obtener_datos_personaje', 'ComicController@obtener_datos_personaje')->name('obtener_datos_personaje');
    //////////////////////////////////////FIN COMIC CONTROLLER///////////////////////////////////////////////

});

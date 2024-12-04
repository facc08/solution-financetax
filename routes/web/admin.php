<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('auth')->group(function(){

    Route::get('/', 'AdminController@Inicio')->name('admin.index');
    Route::get('/mi-perfil', 'AdminController@perfil')->name('admin.perfil.me');
    Route::get('/mis-empresas/{tipo}', 'AdminController@mis_empresas')->name('admin.mis.empresas');
    Route::get('/mis-tarjetas-credito', 'AdminController@tarjeta_credito')->name('admin.mis.tarjetas-credito');

    Route::group(['middleware' => ['role_or_permission:super-admin|usuarios']], function(){

        Route::get('/control-permisos', 'AdminController@index3')->name('admin.control.permisos');
        Route::get('/lista-usuarios', 'AdminController@index4')->name('admin.usuario.index');

    });

    Route::get('/actividades-online', 'AdminController@index2')->name('admin.actividades');
    Route::get('/post-online', 'AdminController@index')->name('admin.post');


});

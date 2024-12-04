<?php

use Illuminate\Support\Facades\Route;


Route::prefix('indicadores')->group(function(){

    Route::group(['middleware'=>['role_or_permission:super-admin|indicadores']], function(){
        //RUTAS DE REPORTES
        Route::get('/indicador-razon-corriente', 'Indicadores\IndicadorController@Razoncorriente')->name('indicador.razon.corriente'); //indicador de liquidez- razon corriente
      });


});
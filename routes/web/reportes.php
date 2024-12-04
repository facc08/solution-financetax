<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de reportes
Route::prefix('reportes')->group(function(){

    Route::group(['middleware'=>['role_or_permission:super-admin|reportes']], function(){
        //RUTAS DE REPORTES
        Route::get('/reporte-usuarios', 'Reportes\ReporteController@ReporteEdad')->name('reportes.usuario'); //reporte por edad usuarios
        Route::get('/reporte-usuarios-ciudad', 'Reportes\ReporteController@ReporteCiudad')->name('reportes.usuario.ciudad'); //reporte por edad usuarios
        Route::get('/reporte-generos', 'Reportes\ReporteController@ReporteGenero')->name('reportes.genero'); //reporte por genero usuarios
        Route::get('/reporte-usuario-telefono', 'Reportes\ReporteController@ReporteTelefono')->name('reportes.usuario.telefono'); //reporte por telefono usuarios
        Route::get('/reporte-usuario-email', 'Reportes\ReporteController@ReporteEmail')->name('reportes.usuario.email'); //reporte por telefono usuarios

        Route::get('/formulario104', 'Reportes\FormulariosController@Formulario104')->name('reportes.formulario104');
        Route::get('/formulario104/consultar/{shop}', 'Reportes\FormulariosController@Consultar104')->name('reportes.formulario104.consultar');
        Route::get('/formulario104/detalle/{empresa}/{anio}/{mes}', 'Reportes\FormulariosController@Detalle104')->name('reportes.formulario104.detalle');
        Route::get('/formulario104/generarXML/{empresa}/{anio}/{mes}', 'Reportes\FormulariosController@generarXML')->name('reportes.generarXML');
        Route::get('/formulario104/generarPDF/{empresa}/{anio}/{mes}', 'Reportes\FormulariosController@generarPDF')->name('reportes.generarPDF');

        Route::get('/formulario4', 'Reportes\FormulariosController@Formulario4')->name('reportes.formulario4');
        Route::get('/formulario4/consultar/{shop}', 'Reportes\FormulariosController@Consultar4')->name('reportes.formulario4.consultar');
        Route::get('/formulario4/detalle/{empresa}/{anio}/{mes}', 'Reportes\FormulariosController@Detalle4')->name('reportes.formulario4.detalle');
        Route::get('/formulario4/generarXML/{empresa}/{anio}/{mes}', 'Reportes\FormulariosController@generarXML104')->name('reportes.generarXML');
        Route::get('/formulario4/generarPDF/{empresa}/{anio}/{mes}', 'Reportes\FormulariosController@generarPDF104')->name('reportes.generarPDF');

        Route::get('/indicadores', 'Reportes\IndicadoresController@index')->name('reportes.indicadores');
        Route::get('/indicadores/principal/{shop}', 'Reportes\IndicadoresController@indicadores')->name('reportes.indicadores.principal');
        Route::get('/indicadores/consultar/{shop}', 'Reportes\IndicadoresController@consultar')->name('reportes.indicadores.consultar');
        Route::get('/indicadores/detalle/{empresa}/{anio}/{mes}', 'Reportes\IndicadoresController@detalle')->name('reportes.indicadores.detalle');
        Route::get('/indicadores/generarPDF/{shop}/{formula}/{valores}', 'Reportes\IndicadoresController@generarPDF')->name('reportes.indicadores.generarPDF');

        Route::get('/ratios', 'Reportes\RatiosController@index')->name('reportes.ratios');
        Route::get('/ratios/principal/{shop}', 'Reportes\RatiosController@ratios')->name('reportes.ratios.principal');
        Route::get('/ratios/generarPDF/{shop}/{variables}/{formulas}', 'Reportes\RatiosController@generarPDF')->name('reportes.ratios.generarPDF');
    });

    Route::group(['middleware'=>['role_or_permission:m-formulas']], function(){
        Route::get('/formulas', 'Reportes\FormulasController@index')->name('reportes.formulas');
        Route::get('/formulas/detalle/{id}', 'Reportes\FormulasController@detalle')->name('reportes.formulas.detalle');
        Route::post('/formulas/crear', 'Reportes\FormulasController@crear')->name('reportes.formulas.crear');
        Route::post('/formulas/editar/{id}', 'Reportes\FormulasController@edit')->name('reportes.formulas.edit');
        Route::post('/formulas/eliminar/{id}', 'Reportes\FormulasController@delete')->name('reportes.formulas.delete');
    });

});

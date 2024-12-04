<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GraficosController;

//rutas del menu de mantenimiento
Route::prefix('servicios')->group(function(){

       Route::group(['middleware'=>['role_or_permission:super-admin|m-tipoplan']], function(){
              //RUTAS DE LOS TIPOS DE PLANES 
              Route::get('/tipo-planes', 'Servicios\ServicioController@TipoPlanes')->name('servicios.tipo.planes'); //ruta tipo planes index

       });
       Route::group(['middleware'=>['role_or_permission:super-admin|m-plan']], function(){
            //RUTAS DE LOS  PLANES
            Route::get('/planes', 'Servicios\PlanController@Planes')->name('servicios.planes'); //indice de los planes
            Route::get('/crear-plan', 'Servicios\PlanController@Plan')->name('servicios.planes.create');// crud de creacion de un plan
            Route::post('/store-plan', 'Servicios\PlanController@Store')->name('servicios.planes.store'); //crud de almacenamiento de un plan
            Route::get('/acciones-plan', 'Servicios\PlanController@AccionesPlan')->name('servicios.planes.accionesPlan');
       });

       Route::group(['middleware'=>['role_or_permission:super-admin|m-tiposervicio']], function(){
              //RUTAS DE LOS TIPOS DE SERVICIOS
              Route::get('/tipo-servicios', 'Servicios\ServicioController@TipoServicio')->name('servicios.tiposervicio'); //ruta de tipo servicios 
       });

       Route::group(['middleware'=>['role_or_permission:super-admin|m-servicio']], function(){
              //RUTAS DE SERVICIOS
              Route::get('/servicios', 'Servicios\ServicioController@Servicio')->name('servicios.servicio'); //ruta de servicios 
              Route::get('/nuevo-servicio', 'Servicios\ServicioController@CreateServicio')->name('servicios.servicio.create');// crear servicio
              Route::post('/store-servicio', 'Servicios\ServicioController@Store')->name('servicios.servicio.store');// guardar servicio
       });
    
       Route::group(['middleware'=>['role_or_permission:super-admin|m-subservicio']], function(){
              //RUTAS DE LOS SUBSERVICIOS
              Route::get('/sub-servicios', 'Servicios\SubserviceController@Index')->name('servicios.subservicio.index'); //indice de un subservicio
              Route::get('/subservicios', 'Servicios\SubserviceController@Sub_service')->name('servicios.subservicio.create'); //creacion de un subservicio
              Route::post('/store-subservicios', 'Servicios\SubserviceController@store')->name('servicios.subservicio.store'); //store de un subservicio
       });

       Route::group(['middleware'=>['role_or_permission:super-admin|m-tipocuenta']], function(){
              //RUTA DE TIPO CUENTA
              Route::get('/tipo-cuenta', 'Servicios\ServicioController@Tipocuenta')->name('tipocuenta.index'); //ruta de tipo cuenta 
       });

       Route::group(['middleware'=>['role_or_permission:super-admin|m-plancontable|c-servicios']], function(){
       //Route::group(['middleware'=>['role_or_permission:m-plancontable|c-servicios']], function(){
              //RUTAS DE PLAN CONTABLE
              Route::get('/plan-contable', 'Servicios\ServicioController@Plancontable')->name('plancontable.index'); //ruta de plan contable
              Route::get('/plan-contable-empresa/{id}', 'Servicios\ServicioController@ShowPlancontable');
              Route::get('/consultaCodigoCuenta/{id}', 'Servicios\ServicioController@consultaCodigoCuenta');
              Route::get('/exportarPlanContable/{id}', 'Servicios\ServicioController@exportarPlanContable');
       });

       Route::group(['middleware'=>['role_or_permission:super-admin|m-impuesto']], function(){
              //RUTAS DE LOS  IMPUESTOS SRI
              Route::get('/impuesto-sri', 'Servicios\ServicioController@Impuestosri')->name('impuestosri.index'); //ruta de ruta de impuesto sri
       });
       Route::group(['middleware'=>['role_or_permission:super-admin|m-proyecciones']], function(){
              //RUTAS DE PROYECCIONES
              Route::get('/proyeccion-gastos-personales', 'Servicios\ServicioController@ProyeccionGasto')->name('proyecciongasto.index');
              //Route::get('/proyeccion-gastos-personales/{id}', 'Servicios\ServicioController@ShowProyeccionGasto');
       });
       Route::view('servicios/contabilidad', 'grafico.contabilidad.index')->name('servicios.contabilidad.index'); //Interface Grafica Servicio Contabilidad
});

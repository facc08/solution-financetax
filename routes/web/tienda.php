<?php

use Illuminate\Support\Facades\Route;
use App\Servicios\Service;

Route::prefix('tienda')->group(function(){


    Route::group(['middleware'=>['role_or_permission:super-admin|c-servicios']], function(){
    //Route::group(['middleware'=>['role_or_permission:c-servicios']], function(){

        Route::get('/tienda-solution/{id}', 'Tienda\ShopController@Index')->name('tienda.index');  //ruta index tienda donde se encuentra los servicios
        Route::get('/servicios/{slug}','Tienda\ShopController@access')->name('subservicios');   //ruta para acceder a los subservicios de cada servicio
        Route::get('/detalle-subservicios/{slug}','Tienda\ShopController@access2')->name('subservicios.detalle');
        Route::post('/obtener-plan', 'Tienda\ShopController@getPlanes')->name('tienda.obtener.plan');  //ruta obtener el plan del tipo de plan
        Route::post('/storeplan', 'Tienda\ShopController@Storee')->name('store.plan.cliente'); //crud de almacenamiento de un plan
        Route::post('/upload', 'Tienda\ShopController@store')->name('documentos.files.stores'); //para subir requisitos en la interaccion

        Route::post('/consultaEmpresa', 'Tienda\ShopController@consultaEmpresa')->name('tienda.consultaEmpresa');

    });

    Route::group(['middleware'=>['role_or_permission:super-admin|c-misservicios']], function(){
    //Route::group(['middleware'=>['role_or_permission:c-misservicios']], function(){
        //lista de planes que ha comprado el cliente
        Route::get('/lista-compra', 'Tienda\ShopController@ListaPlanesCliente')->name('cliente.lista.index');
        Route::get('/show-detalle-compra/{shop}/show', 'Tienda\ClienteController@ShowDataCliente')->name('cliente.detalle.compra');
        Route::get('/interaccion-compra/{shop}/show', 'Tienda\ClienteController@InteraccionCliente')->name('cliente.interaccion');
        Route::post('/upload', 'Tienda\ClienteController@store')->name('documentos.files.stores'); //para subir requisitos en la interaccion




    });

    Route::group(['middleware'=>['role_or_permission:super-admin|c-admtienda']], function(){
    //Route::group(['middleware'=>['role_or_permission:c-admtienda']], function(){
        //RUTA DE LISTA DE PLANES SOLICITADOS POR EL CLIENTE
        Route::get('/admin-planes', 'Tienda\ShopController@adminplanindex')->name('admin.tienda.index');
        Route::get('/detalle-plan/{shop}/show', 'Tienda\ShopController@Showdetalle')->name('compra.detalle.show'); //detalle general de cada solicitud de compra por parte del cliente en la vista de administracion de planes generales



    });

    Route::group(['middleware'=>['role_or_permission:super-admin|c-miadmtienda']], function(){
    //Route::group(['middleware'=>['role_or_permission:c-miadmtienda']], function(){
        //RUTA DE ADMINISTRACION DE COMPRA QUE HA TOMADO CADA ESPECIALISTA
        Route::get('/mi-administracion-plan', 'Tienda\ShopController@MiadminPlan')->name('me.admin.tienda.index');
        Route::get('/detalle-plan-individual/{shop}/show', 'Tienda\ShopController@Showdetalleindividual')->name('compra.detalle.individual.show'); //vista del detalle de los planes elegidos por el especialista
        Route::get('/interaccion-compra-especialista/{shop}/show', 'Tienda\ShopController@InteraccionEspecialista')->name('tienda.interaccion');

    });


    Route::get('/respuestaPago/{transaccion}/{client}', 'Tienda\ShopController@respuestaPago');



});

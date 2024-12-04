<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;



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

//ruta para inicio con video
Route::get('/', function () {
    return view('welcome2');
});
Route::get('/page', function () {
    return view('welcome');
});

Route::get('/offline', function () {
    return view('vendor/laravelpwa/offline');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
 //Route::get('/', 'HomeController@index')->name('index');  // para que acceda solo a home sin entrar a welcome nse comenta




//Routas del landing Page de TAX Solution Finance
Route::get('/nosotros-solution', 'Vista\VistaController@Nosotros')->name('landing.nosotros.tax');
Route::get('/nuestro-equipo', 'Vista\VistaController@Nuestro_equipo')->name('landing.nuestro.equipo.tax');
Route::get('/servicios', 'Vista\VistaController@Servicios')->name('landing.servicios.tax');
Route::get('/contactenos', 'Vista\VistaController@Contactenos')->name('landing.contactenos.tax');


Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('send-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('send.password'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::get('/annotate', 'AnnotationController@displayForm');
Route::post('/annotate', 'AnnotationController@annotateImage');


Route::get('validaEmail/{email}', [RegisterController::class, 'validaEmail']);
/*Guardando los documentos temporalmente*/
/* /* para filepond */
/* Route::post('/upload/{id}', 'Tienda\ClienteController@store')->name('documentos.files.stores');
 */

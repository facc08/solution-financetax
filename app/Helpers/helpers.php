<?php


/**
 * para control de rutas con json 
 */

use Illuminate\Support\Facades\Request;

use Illuminate\Support\Str;
use Carbon\Carbon;

if (!function_exists('active')) {
     function active($url){
            return Request::is($url) ? 'active' : '';
     }
 }

//funcion para activar todas las rutas 

if (!function_exists('ActiveAll')) {
       function ActiveAll($rutas){
              foreach ($rutas as $key => $ruta) {
                     if ($ruta->url == Request::is($ruta->url)) {
                            
                            return 'active';
                     }
              }
       }
}


//funcion para expandir las rutas 
 if (!function_exists('expanded')) {
        function expanded($rutas){
              foreach ($rutas as $key => $ruta) {
                     if ($ruta->url == Request::is($ruta->url)) {
                            return 'true';
                     }else{
                            $data = 'false';
                     }
              }
        }
 }


 //para la expansion y colocacion del submenu 

 //todavia queda enobservacion esta funcion 

 if (!function_exists('submenu')) {
        function submenu($rutas){
               foreach ($rutas as $key => $ruta) {
                      if ($ruta->url == Request::is($ruta->url)) {
                             return 'recent-submenu ' ;
                             //return 'recent-submenu mini-recent-submenu show' ; para mantener activado el submenu bug con el  Aegis
                      }
               }
        }
 }

 if (!function_exists('submenunieto')) {
       function submenunieto($rutas){
              foreach ($rutas as $key => $ruta) {
                     if ($ruta->url == Request::is($ruta->url)) {
                            return 'recent-submenunieto ' ;
                            //return 'recent-submenu mini-recent-submenu show' ; para mantener activado el submenu bug con el  Aegis
                     }
              }
       }
}

 if (!function_exists('fechaFormat')) {
       function fechaFormat($date)
       {
   
           return Carbon::parse($date)->formatLocalized('%d de %B %Y ');
       }
   }


//  if(!function_exists('Separador')){
//         function Separador()
//         {
//                return Str::slug("");
//         }
//  }

if (!function_exists('starMonth')) {
       function starMonth($format = 'Y-m-d')
       {
           $s = Carbon::now()->startOfMonth();
   
           return $s->format($format);
       }
   }
   
   
   if (!function_exists('finalMes')) {
       function finalMes($format = 'Y-m-d')
       {
           $s = Carbon::now()->endOfMonth();
   
           return $s->format($format);
       }
   }

   if (!function_exists('changeDateFormate')) {
       function changeDateFormate($date, $date_format)
       {
           return Carbon::parse($date)->format($date_format);
       }
   }





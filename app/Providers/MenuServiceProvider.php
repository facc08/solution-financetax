<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Servicios\Tiposervicio;
use Illuminate\Support\Facades\Auth;
use Session;


class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //obtener toda la data del menu.json en este caso VerticalMenu.json 

        //$verticalMenuJson = file_get_contents(base_path('resources/json/verticalMenu.json'));
        //$verticalMenuData = json_decode($verticalMenuJson);

        view()->composer('*', function ($view)
        {
            $verticalMenuJson = file_get_contents(base_path('resources/json/verticalMenu.json'));
            $verticalMenuData = json_decode($verticalMenuJson);

            if (Auth::check()) {
                if(!Auth::user()->hasRole('cliente-contable')){
                    foreach ($verticalMenuData->menu as $key => $value) {
                        if($value->name == "Reportes"){
                            unset($verticalMenuData->menu[$key]);
                        }
                    }
                }

                if(Auth::user()->hasRole('cliente') || Auth::user()->hasRole('cliente-contable') || Auth::user()->hasRole('invitado')){
                    foreach ($verticalMenuData->menu as $key => $value) {
                        if($value->name == "Servicios"){
                            $tipos = Tiposervicio::where("estado", "activo")->get();
                            foreach ($value->submenu as $keySub => $valueSub) {
                                if($valueSub->name == "Lista de Planes"){
                                    foreach ($tipos as $keyTipos => $valueTipos) {
                                        array_push($valueSub->submenunieto, (object)[
                                            'route' => 'tienda.index',
                                            'url' => '/tienda/tienda-solution/'.$valueTipos->id,
                                            'name' => $valueTipos->nombre,
                                            'can' => 'c-servicios',
                                            'icon' => $valueTipos->icon
                                        ]);
                                    }
                                    }
                            }
                        }
                    }
                }
            }

            View::share('menuData',[$verticalMenuData]);
        });

       //compartimos todo el menuData a todas las vistas
       //View::share('menuData',[$verticalMenuData]);

    }
}

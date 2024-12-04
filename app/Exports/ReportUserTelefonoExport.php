<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ReportUserTelefonoExport implements FromView
{
    use Exportable;

    protected $users;

    public function __construct($datos)
    {
        $this->users = $datos;
        
    }

    public function view(): View
    {
              return view('cruds.reportes.excel.reporte-telefono-usuario',[
                  'users' => $this->users
              ]);
    }

}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;;

class ReportUserEmailExport implements FromView
{
    use Exportable;

    public function __construct($datos)
    {
        $this->users = $datos;
        
    }

    public function view(): View
    {
              return view('cruds.reportes.excel.reporte-email-usuario',[
                  'users' => $this->users
              ]);
    }
    
}

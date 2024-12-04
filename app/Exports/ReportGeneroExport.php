<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportGeneroExport implements FromView
{
  use Exportable;

  protected $users;

  public function __construct($datos)
  {
      $this->users =  $datos;

  }

  public function view(): View
  {
            return view('cruds.reportes.excel.reporte-genero-usuarios',[
                'users' => $this->users
            ]);
  }

}


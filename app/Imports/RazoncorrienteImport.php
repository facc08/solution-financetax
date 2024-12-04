<?php

namespace App\Imports;

use App\Indicador\Razoncorriente;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RazoncorrienteImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //dd($row);
        return new Razoncorriente([
            
            
            'activo_corriente'   => $row['activo_corriente'],
            'pasivo_corriente'   => $row['pasivo_corriente'],
            'periodo'            => $row['periodo'],
            'user_id'            => Auth::user()->id,
        ]);
    }

    public function headingRow(): int
    {
        return 5;
    }

}

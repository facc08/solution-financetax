<?php

namespace App\Exports;

use App\Servicios\Plancontable;
use App\UserEmpresa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class PlanContableExport implements FromQuery, WithProperties, WithTitle, WithHeadings, WithColumnFormatting
{
    use Exportable;

    public function __construct(int $id)
    {
        $this->idEmpresa = $id;
    }

    public function properties(): array
    {
        return [
            'title'          => "Plan Contable",
            'description'    => 'Plan Contable - Generado por Solution Financetax.'
        ];
    }

    public function query()
    {
        return Plancontable::leftJoin('proyeccions', 'plancontables.proyeccions_id', 'proyeccions.id')
                            ->where('plancontables.user_empresa_id', '=', $this->idEmpresa)
                            ->select('plancontables.codigo as Codigo', 'plancontables.cuenta as Cuenta Contable', 'plancontables.cuenta_padre as Cuenta Padre',
                                     'plancontables.nivel as Nivel', 'proyeccions.descripcion as Categoria')
                            ->orderBy('plancontables.id', 'asc');
    }

    public function title(): string
    {
        $userEmpresa = UserEmpresa::find($this->idEmpresa);

        return 'Plan Contable '.$userEmpresa->razon_social;
    }

    public function headings(): array
    {
        return ["Codigo Cuenta", "Cuenta Contable", "Cuenta Padre", "Nivel", "Categoria"];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'C' => NumberFormat::FORMAT_NUMBER,
            'D' => NumberFormat::FORMAT_NUMBER,
        ];
    }

}

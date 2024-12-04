<?php

namespace App\Exports;

use App\TipoTransaccion;
use App\TransaccionDiaria;
use App\UserEmpresa;
use App\Servicios\Proyeccion;
use App\Servicios\Plancontable;
use App\Servicios\Tiposervicio;
use App\Tienda\Shop;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class TransaccionExport implements FromQuery, WithProperties, WithTitle, WithHeadings, WithColumnFormatting
{
    use Exportable;

    public function __construct(int $id)
    {
        $this->idShop = $id;
    }

    public function properties(): array
    {
        return [
            'title'          => "Transacciones",
            'description'    => 'Transacciones - Generado por Solution Financetax.'
        ];
    }

    public function query()
    {
        return TransaccionDiaria::join('tipotransaccion', 'tipotransaccion.id', '=', 'transacciondiaria.tipotransaccion_id')
                                    ->join('proyeccions', 'proyeccions.id', '=', 'transacciondiaria.proyeccions_id')
                                    ->leftJoin('plancontables', 'plancontables.id', 'transacciondiaria.plancuenta_id')
                                    ->select('tipotransaccion.nombre',
                                            'plancontables.codigo',
                                            'plancontables.cuenta',
                                            'proyeccions.descripcion',
                                            'transacciondiaria.detalle',
                                            'transacciondiaria.tarifacero',
                                            'transacciondiaria.tarifadifcero',
                                            'transacciondiaria.iva',
                                            'transacciondiaria.importe',
                                            'transacciondiaria.created_at')
                                    ->where('transacciondiaria.usuarioplan_id', $this->idShop)
                                    ->where('transacciondiaria.estado','=','activo');
    }

    public function title(): string
    {
        $shop = Shop::find($this->idShop);
        $empresa = UserEmpresa::find($shop->user_empresas_id);

        return 'Transacciones '.$empresa->razon_social;
    }

    public function headings(): array
    {
        return ["TIPO TRANSACCION", "CODIGO CUENTA", "CUENTA", "CATEGORIA", "DETALLE DOCUMENTO", "TARIFA 0%", "TARIFA DIF. 0%", "IVA", "IMPORTE", "FECHA REGISTRO"];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_NUMBER_00,
            'G' => NumberFormat::FORMAT_NUMBER_00,
            'H' => NumberFormat::FORMAT_NUMBER_00,
            'I' => NumberFormat::FORMAT_NUMBER_00,
            'J' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}

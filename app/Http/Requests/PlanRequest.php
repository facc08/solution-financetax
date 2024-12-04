<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'service_id' => 'required',
            'tipoplan_id' => 'required',
            'costo' => 'required',
            'descripcion' => 'required',
            'documento' => 'max:154000|mimes:jpg,jpeg,png,csv,txt,xlx,xls,docx,pdf',
        ];
    }
    public function messages()
    {
        return [
            'service_id.required'  => 'No has seleccionado el Sub Servicio',
            'tipoplan_id.required'    => 'No has seleccionado el Tipo PLan',
            'costo.required'          => 'No has Añadido el Precio',
            'descripcion.required'    => 'No has Añadido La Descripción ',
            'documento.max'           => 'El tamaño del archivo supera al permitido por el sistema',
            'documento.mimes'         => 'Solo puedes cargar archivos de tipo: jpg, jpeg, png, csv, txt, xlx, xls, docx, pdf',
             ];
    }


}

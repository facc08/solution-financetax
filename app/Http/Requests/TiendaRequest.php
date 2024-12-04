<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TiendaRequest extends FormRequest
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
            
            
        ];
    }

    public function messages()
    {
        return [
            'service_id.required'     => 'No has seleccionado el Servicio',
            'tipoplan_id.required'       => 'No has Añadido el Nombre del TipoPlan',
            'costo.required'             => 'No se ha guardado el costo ',
            ];
    }
}

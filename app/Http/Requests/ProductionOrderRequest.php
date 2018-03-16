<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductionOrderRequest extends FormRequest
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
            
            'id_producto_mp' => 'required',
            'etiqueta_mp' => 'required',
            'id_producto_core' => 'required',
            'etiqueta_core' => 'required',
            'id_producto_leader1' => 'required',
            'etiqueta_leader1' => 'required',
            'id_producto_leader2' => 'required',
            'etiqueta_leader2' => 'required',
            'id_producto_sticker' => 'required',
            'etiqueta_sticker' => 'required',
            'direction' => 'required'



        ];
    }

    public function messages()
    {
        return [
            'id_producto_mp.required' => 'Materia prima  es requerido',
            'etiqueta_mp.required' => 'Etiqueta o lote Materia prima es requerido',
            'id_producto_core.required' => 'Core es requerido',
            'etiqueta_core.required' => 'Etiqueta core es requerido',
            'id_producto_leader1.required' => 'Leader de inicio es requerido',
            'etiqueta_leader1.required' => 'Etiqueta o lote leader inicio es requerido',
            'id_producto_leader2.required' => 'Leader final es requerido',
            'etiqueta_leader2.required' => 'Etiqueta o lote leader final es requerido',
            'id_producto_sticker.required' => 'Sticker es requerido',
            'etiqueta_sticker.required' => 'Lote sticker es requerido',
            'direction.required' => 'Dirección es  requerido'
        ];
    }
}

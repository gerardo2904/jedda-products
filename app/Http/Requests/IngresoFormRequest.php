<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngresoFormRequest extends FormRequest
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
            'idproveedor' => 'required',
            'id_empresa' => 'required',
            'tipo_comprobante' => 'required|max:20',
            'serie_comprobante' => 'required|max:20',
            'num_comprobante' => 'required|max:10',
            'id_articulo' => 'required',
            'cantidad' => 'required',
            'precioc' => 'required',
            'ordenp' => 'unique:ingreso'
        ];
    }

    public function messages()
    {
        return [
            'idproveedor.required' => 'Proveedor es requerido',
            'id_empresa.required' => 'Empresa es requerido',
            'tipo_comprobante.required' => 'Tipo de comprobante requerido',
            'serie_comprobante.required' => 'Serie de comprobante requerido',
            'num_comprobante.required' => 'Numero de comprobante requerido',
            'id_articulo.required' => 'Articulo requerido',
            'cantidad.required' => 'Cantidad requerido',
            'precioc.required' => 'Precio de compra requerido',
            'ordenp.unique' => 'Orden de producción repetida, favor de comprobar. Por seguridad, captura la orden correcta y vuelve a capturar los productos.'
        ];
    }
}

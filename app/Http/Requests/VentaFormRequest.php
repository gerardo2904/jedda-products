<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaFormRequest extends FormRequest
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
            'idcliente' => 'required',
            'id_empresa' => 'required',
            'tipo_comprobante' => 'required|max:20',
            'serie_comprobante' => 'required|max:20',
            'num_comprobante' => 'required|max:10',
            'id_articulo' => 'required',
            'cantidad' => 'required',
            'preciov' => 'required',
            'total_venta' => 'required',
            'ordenq' => 'unique:venta'
        ];
    }

    public function messages()
    {
        return [
            'idcliente.required' => 'Cliente es requerido',
            'id_empresa.required' => 'Empresa es requerido',
            'tipo_comprobante.required' => 'Tipo de comprobante requerido',
            'serie_comprobante.required' => 'Serie de comprobante requerido',
            'num_comprobante.required' => 'Numero de comprobante requerido',
            'id_articulo.required' => 'Articulo requerido',
            'cantidad.required' => 'Cantidad requerido',
            'preciov.required' => 'Precio de venta requerido',
            'total_venta.required' => 'Total de venta requerido',
            'ordenq.unique' => 'Orden de QuickBooks repetida, favor de comprobar. Por seguridad, captura la orden correcta y vuelve a capturar los productos.'
        ];
    }
}

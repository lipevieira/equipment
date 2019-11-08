<?php

namespace App\Http\Requests\Link;

use Illuminate\Foundation\Http\FormRequest;


class LinkFormRequest extends FormRequest
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
            'secretaria_orgao' => 'required|max:100',
            'velocidade' => 'required|max:100',
            'logradouro' => 'required|max:255',
            'numero' => 'required|max:100',
            'bairro' => 'required|max:255',
            'ponto_referencia' => 'required|max:150',
            'cep' => 'required|max:12',
            'localidade' => 'required|max:100',           
        ];
    }
}

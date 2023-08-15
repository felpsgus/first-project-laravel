<?php

namespace App\Http\Requests\Endereco;

use Illuminate\Foundation\Http\FormRequest;

class SaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'logradouro' => '',
            'bairro' => '',
            'cep' => 'required|string',
            'cidade' => 'required|string',
            'uf' => 'required|string',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'address'      => 'required|string|max:255',
            'number'       => 'required|integer',
            'neighborhood' => 'required|string|max:255',
            'complement'   => 'nullable|string|max:255',
            'city'         => 'required|string|max:255',
            'state'        => 'required|string|size:2',
        ];
    }

    public function messages(): array
    {
        return [
            'address.required'      => 'O endereço é obrigatório.',
            'address.string'        => 'O endereço deve ser um texto.',
            'address.max'           => 'O endereço deve ter no máximo 255 caracteres.',

            'number.required'       => 'O número é obrigatório.',
            'number.integer'        => 'O número deve ser um valor numérico inteiro.',

            'neighborhood.required' => 'O bairro é obrigatório.',
            'neighborhood.string'   => 'O bairro deve ser um texto.',
            'neighborhood.max'      => 'O bairro deve ter no máximo 255 caracteres.',

            'complement.string'     => 'O complemento deve ser um texto.',
            'complement.max'        => 'O complemento deve ter no máximo 255 caracteres.',

            'city.required'         => 'A cidade é obrigatória.',
            'city.string'           => 'A cidade deve ser um texto.',
            'city.max'              => 'A cidade deve ter no máximo 255 caracteres.',

            'state.required'        => 'O estado (UF) é obrigatório.',
            'state.string'          => 'O estado (UF) deve ser um texto.',
            'state.size'            => 'O estado (UF) deve conter exatamente 2 caracteres.',
        ];
    }
}

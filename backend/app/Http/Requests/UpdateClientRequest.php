<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidateCpfCnpj;
use  App\Models\Client;

class UpdateClientRequest extends FormRequest
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
        $clientId = $this->route('id');

        return [
            'name'            => 'required|string|max:255',
            'birth_date'      => 'required|date|before:today',
            'person_type'     => 'required|in:F,J',
            'cpf_cnpj'        => [
                'required',
                'string',
                'max:18',
                new validateCpfCnpj()
            ],
            'email'           => 'required|email|max:255',
            'phone'           => 'required|string|max:25',
            'address'         => 'required|string|max:255',
            'number'          => 'required|integer',
            'neighborhood'    => 'required|string|max:255',
            'complement'      => 'nullable|string|max:255',
            'city'            => 'required|string|max:255',
            'state'           => 'required|string|size:2',
            'profession_name' => 'required|string|max:255',
            'active'          => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required'            => 'O nome é obrigatório.',
            'name.string'            => 'O nome deve ser um texto.',
            'name.max'               => 'O nome deve ter no máximo 255 caracteres.',

            'birth_date.required'      => 'A data de nascimento é obrigatória.',
            'birth_date.date'          => 'A data de nascimento deve ser uma data válida.',
            'birth_date.before'        => 'A data de nascimento deve ser anterior à data atual.',

            'person_type.required'     => 'O tipo de pessoa é obrigatório.',
            'person_type.in'           => 'O tipo de pessoa deve ser F (física) ou J (jurídica).',

            'cpf_cnpj.required'        => 'O CPF/CNPJ é obrigatório.',
            'cpf_cnpj.string'          => 'O CPF/CNPJ deve ser um texto.',
            'cpf_cnpj.size'            => 'O CPF ou CNPJ deve conter no máximo 18 caractere, incluindo pontos.',
            'cpf_cnpj.unique'          => 'Já existe um cliente cadastrado com este CPF/CNPJ e e-mail.',

            'email.required'           => 'O e-mail é obrigatório.',
            'email.email'              => 'O e-mail deve ser um endereço de e-mail válido.',
            'email.max'                => 'O e-mail deve ter no máximo 255 caracteres.',

            'phone.required'           => 'O telefone é obrigatório.',
            'phone.string'             => 'O telefone deve ser um texto.',
            'phone.max'                => 'O telefone deve ter no máximo 25 caracteres.',

            'address.required'         => 'O endereço é obrigatório.',
            'address.string'           => 'O endereço deve ser um texto.',
            'address.max'              => 'O endereço deve ter no máximo 255 caracteres.',

            'number.required'          => 'O número é obrigatório.',
            'number.integer'           => 'O número deve ser um valor inteiro.',

            'neighborhood.required'    => 'O bairro é obrigatório.',
            'neighborhood.string'      => 'O bairro deve ser um texto.',
            'neighborhood.max'         => 'O bairro deve ter no máximo 255 caracteres.',

            'complement.string'        => 'O complemento deve ser um texto.',
            'complement.max'           => 'O complemento deve ter no máximo 255 caracteres.',

            'city.required'            => 'A cidade é obrigatória.',
            'city.string'              => 'A cidade deve ser um texto.',
            'city.max'                 => 'A cidade deve ter no máximo 255 caracteres.',

            'state.required'           => 'O estado é obrigatório.',
            'state.string'             => 'O estado deve ser um texto.',
            'state.size'               => 'O estado deve conter exatamente 2 letras.',

            'profession_name.required' => 'A profissão é obrigatória.',
            'profession_name.string'   => 'A profissão deve ser um texto.',
            'profession_name.max'      => 'A profissão deve ter no máximo 255 caracteres.',

            'active.required'          => 'O campo ativo é obrigatório.',
            'active.boolean'           => 'O campo ativo deve ser verdadeiro ou falso.',
        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $exists = Client::where('cpf_cnpj', $this->input('cpf_cnpj'))
                ->where('email', $this->input('email'))
                ->where('id', '!=', $this->route('client')->id)
                ->exists();

            if ($exists) {
                $validator->errors()->add('cpf_cnpj', 'Já existe um cliente com este CPF/CNPJ e e-mail.');
            }
        });
    }
}

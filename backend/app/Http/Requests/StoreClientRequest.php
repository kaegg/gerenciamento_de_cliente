<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\validateCpfCnpj;

class StoreClientRequest extends FormRequest
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
            'name'            => 'required|string|max:255',
            'birth_date'      => 'required|date|before:today',
            'person_type'     => 'required|in:F,J',
            'cpf_cnpj'        => [
                'required',
                'string',
                new validateCpfCnpj(),
                Rule::unique('clients')->where(function($query){
                    return $query->where('email', $this->input('email'));
                })
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
            'name.required'          => 'O nome é obrigatório.',
            'name.string'            => 'O nome deve ser um texto.',
            'name.max'               => 'O nome deve ter no máximo 255 caracteres.',

            'birth_date.required'    => 'A data de nascimento é obrigatória.',
            'birth_date.date'        => 'A data de nascimento deve ser uma data válida.',
            'birth_date.before'      => 'A data de nascimento deve ser anterior à data atual.',

            'person_type.required'   => 'O tipo de pessoa é obrigatório.',
            'person_type.in'         => 'O tipo de pessoa deve ser "F" (Física) ou "J" (Jurídica).',

            'cpf_cnpj.required'      => 'O CPF ou CNPJ é obrigatório.',
            'cpf_cnpj.string'        => 'O CPF ou CNPJ deve ser um texto.',
            'cpf_cnpj.size'          => 'O CPF ou CNPJ deve ter exatamente 14 caracteres (sem pontos ou traços).',
            'cpf_cnpj.unique'        => 'Já existe um cliente cadastrado com este CPF/CNPJ e e-mail.',

            'email.required'         => 'O e-mail é obrigatório.',
            'email.email'            => 'O e-mail deve ser um endereço válido.',
            'email.max'              => 'O e-mail deve ter no máximo 255 caracteres.',

            'phone.required'         => 'O telefone é obrigatório.',
            'phone.string'           => 'O telefone deve ser um texto.',
            'phone.max'              => 'O telefone deve ter no máximo 25 caracteres.',

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

            'profession_name.required' => 'O nome da profissão deve ser preenchido.',
            'profession_name.unique'   => 'Esta profissão já está cadastrada.',
            'profession_name.max'      => 'O nome da profissão não pode passar de 255 caracteres.',

            'active.required'        => 'O campo ativo é obrigatório.',
            'active.boolean'         => 'O campo ativo deve ser verdadeiro ou falso.',
        ];
    }
}

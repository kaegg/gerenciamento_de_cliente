<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfessionRequest extends FormRequest
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
            'profession_name' => 'required|string|max:255|unique:professions,profession_name',
        ];
    }

    public function messages(): array
    {
        return [
            'profession_name.required' => 'O nome da profissão deve ser preenchido.',
            'profession_name.unique'   => 'Esta profissão já está cadastrada.',
            'profession_name.max'      => 'O nome da profissão não pode passar de 255 caracteres.',
        ];
    }

}

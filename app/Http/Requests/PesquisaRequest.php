<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PesquisaRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['pesquisa'] = 'required';
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute não pode ser vazio.',
        ];
    }

}
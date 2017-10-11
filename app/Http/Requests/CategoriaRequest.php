<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $rules['nome'] = 'required|min:5';

        if(!$this->has('id')){
            $rules['imagem'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute não pode ser vazio.',
        ];
    }

}
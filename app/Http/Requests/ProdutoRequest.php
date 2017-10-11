<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $rules['nome'] = 'required|min:5';
        $rules['descricao'] = 'required|min:5';
        $rules['categorias'] = 'required_without_all';

        if(!$this->has('id')){
            $rules['imagem'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        return $rules;

    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute não pode ser vazio.',
            'min' => 'O tamanho do campo :attribute deve ser maior que 5.',
            'required_without_all' => 'O produto deve possuir pelo menos 1 categoria.',
        ];
    }

}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:products|max:255',
            'image' => 'required|image',
            'description' => 'required',
            'price' => 'required',
            'discount' => 'required|max:2',
            'stock' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'image.required' => 'O campo de imagem é obrigatório',
            'description.required' => 'O campo descrição é obrigatório',
            'price.required' => 'O campo preço é obrigatório',
            'discount.required' => 'O campo desconto é obrigatório',
            'discount.max' => 'Máximo de 2 caracteres no campo desconto',
            'stock.required' => 'O campo estoque é obrigatório',
            'category_id.required' => 'É obrigatório o produto conter uma categoria',
            'image.image' => 'O campo imagem deve conter um arquivo do tipo imagem',
            'name.unique' => 'Esse nome de produto já foi cadastrado, tente outro'
        ];
    }
}

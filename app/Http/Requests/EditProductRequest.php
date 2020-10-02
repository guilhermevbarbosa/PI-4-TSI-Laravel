<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:255', \Illuminate\Validation\Rule::unique('products')->ignore($this->product['id'])],
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
            'name.unique' => 'Esse nome de produto já foi cadastrado, tente outro',
            'name.max' => 'O campo nome deve ter no máximo :max caracteres',
            'name.min' => 'O campo nome deve ter no mínimo :min caracteres',
            'description.required' => 'O campo descrição é obrigatório',
            'price.required' => 'O campo preço é obrigatório',
            'discount.required' => 'O campo desconto é obrigatório',
            'discount.max' => 'Máximo de 2 caracteres no campo desconto',
            'stock.required' => 'O campo estoque é obrigatório',
            'category_id.required' => 'É obrigatório o produto conter uma categoria'
        ];
    }
}

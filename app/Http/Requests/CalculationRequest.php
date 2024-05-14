<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'transportCompany'=>'required',
            'productType'=>'required',
            'weight'=>'required|numeric|between:30,100000',
            'distance'=>'required|numeric|min:1',
        ];
    }
    public function messages(): array
    {
        return [
            'transportCompany.required'=>'Поле Транспортная компания обязательно',
            'productType.required'=>'Поле Тип товара обязательно',
            'weight.required'=>'Поле Вес обязательно',
            'distance.required'=>'Поле Расстояние обязательно',
            'weight.between'=>'Вес должен быть в пределах :min - :max кг, передано (:input кг)',
            'distance.min'=>'Расстояние должно быть не меньше :min км'
        ];
    }
}

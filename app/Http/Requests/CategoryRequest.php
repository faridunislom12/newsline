<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => '',
            'is_active' => '',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            ['field' => 'name', 'label' => 'Имя'],
            ['field' => 'description', 'label' => 'Описание'],
            ['field' => 'is_active', 'label' => 'Активен', 'filterOptions' => (object)['enabled' => true, 'placeholder' => 'все', 'filterDropdownItems' => [(object)['value' => 0, 'text' => 'не активен'], (object)['value' => 1, 'text' => 'активен']]]],
        ];
    }
}

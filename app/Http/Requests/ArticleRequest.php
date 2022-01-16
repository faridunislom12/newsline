<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'category_id' => 'required',
            'text' => 'required',
            'images' => '',
            'publish_at' => '',
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
            ['field' => 'category.name', 'label' => 'Категория', 'filterOptions' => (object)['enabled' => true, 'placeholder' => 'все', 'filterDropdownItems' => Category::pluck('name')]],
            ['field' => 'text', 'label' => 'Текст'],
            ['field' => 'image', 'label' => 'Изображение'],
            ['field' => 'publish_at', 'label' => 'Дата публикации'],
            ['field' => 'is_active', 'label' => 'Активен'],
        ];
    }
}

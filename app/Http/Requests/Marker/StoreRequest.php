<?php

namespace App\Http\Requests\Marker;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ];
    }
    public function messages()
    {
        //return parent::messages(); // TODO: Change the autogenerated stub
        return [
//            'title.required' => 'Это поле необходимо для заполнения',
//            'title.string' => 'Данные должны соответствовоать строчному типу',
//            'content.required' => 'Это поле необходимо для заполнения',
//            'content.string' => 'Данные должны соответствовоать строчному типу',
//            'preview_image.required' => 'Это поле необходимо для заполнения',
//            'preview_image.file' => 'Это должен быть файл',
//            'main_image.required' => 'Это поле необходимо для заполнения',
//            'main_image.file' => 'Это должен быть файл',
//            'category_id.required' => 'Это поле необходимо для заполнения',
//            'category_id.integer' => 'Id должен быть числом',
//            'category_id.exists' => 'Id категории должен быть в базе',
//            'tag_ids' => 'Необходимо отправить массив данных'
        ];
    }




}

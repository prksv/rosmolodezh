<?php

namespace App\Http\Requests\Track;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->role->name == 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required','unique:tracks'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'icon' => '',
            'body' => ['required'],
            'tg_url' => ['required','url'],
            'curator_id' => ['required'],
            'teacher_id' => ['array', 'required']
        ];
    }

    /**
     * Validation messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Название направления обязательно',
            'title.unique' => 'Направление с таким названием уже существует',
            'image.required' => 'Изображение направления обязательно',
            'image.image' => 'Здесь должно быть изображение',
            'image.mimes' => 'Изображение должно быть такого формата: .jpg .jpeg .png',
            'image.max' => 'Изображение не должно весить больше 2мб',
            'body.required' => 'Описание направления обязательно',
            'tg_url.required' => 'Ссылка на телеграмм чат направления обязательна',
            'tg_url.url' => 'Это поле должно быть ссылкой',
            'curator_id.required' => 'Выберите куратора направления',
            'teacher_id.required'=>'Выберете преподавател(ей/я) направленя',
        ];
    }
}

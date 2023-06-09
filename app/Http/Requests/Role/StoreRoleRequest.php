<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=> 'required',
            'permission_id' =>['array', 'required']
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'Поле обязательно для заполнения',
            'permission_id.required' => 'Поле обязательно для заполнение'
        ];
    }
}

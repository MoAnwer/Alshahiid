<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
       return [
            'username'  =>  'string|required',
            'password'  =>  'required|string|min:6'
        ];
    }

    public function messages()
    {
        return [
            'username'  => 'اسم المستخدم ضروري',
            'password.required' => 'كلمة السر مطلوبة',
            'password.min'  => 'يجب ان  تحتوي كلمة المرور على 6 احرف على الاقل'
        ];
    }
}

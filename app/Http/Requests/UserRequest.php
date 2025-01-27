<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function rules()
    {
       return [
            'username'   =>  'string|required|unique:users,username',
            'full_name'  =>  'string|required',
            'password'   =>  'required|string|min:6',
            'role'       =>  'required|in:user,admin,moderate'
        ];
    }

    public function messages()
    {
        return [
            'full_name' => 'الاسم الرباعي مطلوب',
            'username.required'  => 'اسم المستخدم ضروري',
            'username.unique'   => 'اسم المستخدم هذا غير متاح, جرب اسم اخر',
            'password.required' => 'كلمة السر مطلوبة',
            'password.min'  => 'يجب ان  تحتوي كلمة المرور على 6 احرف على الاقل',
            'role'  => 'الرجاء تعيين  وظيفة '
        ];
    }
}

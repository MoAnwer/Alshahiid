<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupervisorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'  => 'string|required',
            'phone' => 'required|numeric|unique:supervisors,phone'
        ];
    }

    public function messages()
    {
        return [
            'name'  => 'الاسم المشرف مطلوب',
            'phone.unique' => 'رقم الهاتف موجود بالفعل',
            'phone.numeric'   => 'الرجاء ادخال صيغة صحيحة لرقم الهاتف'
        ];
    }
}

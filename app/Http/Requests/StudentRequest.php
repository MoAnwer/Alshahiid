<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'stage'     => 'required|string',
            'class'     => 'required|string',
            'school_name'     => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'stage' => 'المرحلة الدراسية مطلوبة',
            'class' => 'الصف مطلوب',
            'school_name' => 'اسمة المدرسة مطلوب'
        ];
    }
}

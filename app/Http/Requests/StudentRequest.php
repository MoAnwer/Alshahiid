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
            'stage'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'stage' => 'المرحلة الدراسية مطلوبة'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'storage_path' => 'required',
            'type'  =>  'required|string',
            'notes' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'storage_path' => 'ملف الخطاب مطلوب',
            'type'  =>  'نوع الخطاب مطلوب',
        ];
    }
}

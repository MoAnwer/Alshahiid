<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LectureRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return  [
            'name'  => 'required|string',
            'status'    => 'in:مطلوب,منفذ|required',
            'date'  => 'date|required',
            'budget' => 'required',
            'budget_from_org' => 'nullable|numeric',
            'budget_out_of_org' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'sector' => 'string',
            'locality' => 'string'
        ];
    }

    public function messages()
    {
        return [
            'name'  => 'اسم المعسكر مطلوب',
            'budget'    => 'المبلغ مطلوب',
            'date'  => 'تاريخ المحاضرة مطلوب'
        ];
    }
}

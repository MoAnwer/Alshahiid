<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampRequest extends FormRequest
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
            'start_at'  => 'date|required',
            'end_at'  => 'date|required',
            'budget' => 'required',
            'budget_from_org' => 'nullable|numeric',
            'budget_out_of_org' => 'nullable|numeric',
            'notes' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'name'      => 'اسم المعسكر مطلوب',
            'budget'    => 'المبلغ مطلوب',
            'start_at'  => 'تاريخ بداية المعسكر مطلوب',
            'end_at'  => 'تاريخ انتهاء المعسكر مطلوب',
        ];
    }
}

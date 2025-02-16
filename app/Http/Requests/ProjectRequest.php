<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'project_name'      => 'string|required',
            'project_type'      => "required|in:جماعي,فردي",
            'status'            => 'required|in:مطلوب,منفذ',
            'budget'            => 'numeric|required',
            'budget_from_org'   => 'nullable|numeric',
            'budget_out_of_org' => 'nullable|numeric',           
            'manager_name'      => 'required',
            'notes'             => 'nullable|string',
            'provider'          => 'in:من داخل المنظمة,من خارج المنظمة',
            'monthly_budget'    => 'nullable|numeric',
            'expense'           => 'nullable|numeric',
            'work_status'       => 'required'
        ];
    }

    public function messages()
    {
        return [
            'manager_name'     => 'حقل اسم المدير مطلوب',
            'budget'           => 'حقل المبلغ مطلوب',
            'project_name'     => 'حقل  اسم المشروع مطلوب'
        ];
    }
}

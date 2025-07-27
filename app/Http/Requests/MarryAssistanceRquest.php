<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarryAssistanceRquest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'budget' => 'required|numeric', 
            'status'  => 'required',
            'notes' => 'nullable', 
            'budget_from_org' => 'numeric', 
            'budget_out_of_org' => 'numeric'
        ];
    }

    public function messages() 
    {
        return [
            'budget'    => 'حقل المبلغ مطلوب',
            'budget_from_org' => 'حقل المبلغ المقدم من المنظمة مطلوب',
            'budget_out_of_org' => 'حقل المبلغ المقدم من خارج المنظمة مطلوب'
        ];
    }
}

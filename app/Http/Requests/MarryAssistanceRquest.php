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
            'budget_from_org' => 'nullable|numeric', 
            'budget_out_of_org' => 'nullable|numeric'
        ];
    }

    public function message() 
    {
        return [
            'budget'    => 'حقل البلغ مطلوب'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BailRequest extends FormRequest
{

    public function rules()
    {
        return [
            'provider' => 'in:الحكومة,ديوان الزكاة,دعم شعبي,ايرادات المنظمة', 
            'budget' => 'required|numeric', 
            'status'  => 'required',
            'type' => 'in:مجتمعية,مؤسسية,المنظمة', 
            'notes' => 'nullable', 
            'budget_from_org' => 'nullable|numeric', 
            'budget_out_of_org' => 'nullable|numeric'
        ];
    }

    public function messages() 
    {
        return [
            'budget'    => 'حقل البلغ مطلوب'
        ];
    }
}

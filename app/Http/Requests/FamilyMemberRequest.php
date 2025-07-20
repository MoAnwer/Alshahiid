<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FamilyMemberRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => 'string|required',
            "age" => 'integer|required',
            "gender" => "in:ذكر,أنثى",
            "relation" => "in:اب,ام,اخ,اخت,زوجة,ابن,ابنة",
            // "national_number" => "numeric|unique:family_members,national_number",
            "phone_number" => "string|nullable",
            "birth_date" => "date|required",
            "health_insurance_number" => "numeric|nullable|unique:family_members,health_insurance_number",
            "health_insurance_start_date" => "date|nullable",
            "health_insurance_end_date" => "date|nullable",
            'personal_image' => 'image:mimes:jpg,png,jpeg,gif|nullable'
        ];
    }
    
    public function messages()
    {
        return [
            'name'              => 'حقل الاسم اجباري',
            'age'               => 'حقل العمر اجباري' ,
            'national_number'   => 'الرقم الوطني اجباري',
            'birth_date'        => 'تاريخ الميلاد اجباري',
            'health_insurance_number.unique'   => 'رقم بطاقة التأمين الصحي  موجود بالفعل',
            'national_number.unique'   => 'الرقم الوطني موجود بالفعل',
        ];
    }
}

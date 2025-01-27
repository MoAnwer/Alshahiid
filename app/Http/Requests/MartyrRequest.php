<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class MartyrRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'                   => 'string|required',
            'marital_status'         => 'in:أعزب,متزوج,مطلق,منفصل',
            'martyrdom_date'         => 'date|required',
            'martyrdom_place'        => 'string|required',
            'militarism_number'      => 'numeric|unique:martyrs,militarism_number',
            'rank'                   => 'in:جندي,جندي أول,عريف,وكيل عريف,رقيب,رقيب أول,مساعد,مساعد أول,ملازم,ملازم أول,نقيب,رائد,مقدم,عقيد,عميد,لواء,فريق,فريق أول,مشير',
            'force'                  => 'required',
            'record_number'          => 'numeric|unique:martyrs,record_number',
            'record_date'            => 'date',
            'unit'                   => 'required|string',
            'rights'                 => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name'                   => 'حقل الاسم مطلوب',
            'martyrdom_date'         => 'حقل تاريخ الاستشهاد مطلوب',
            'force'                  => 'حقل القوة اجباري',
            'martyrdom_place'        => 'حقل مكان الاستشهاد مطلوب',
            'rank'                   => 'حقل الرتبة مطلوب',
            'rights'                 => 'حقل حقوق الشهيد مطلوب',
            'record_number'          => 'حقل رقم السجل  مطلوب',
            'record_date'            => 'حقل تاريخ سجل الشهيد مطلوب',
            'militarism_number'      => 'حقل النمرة العسكرية مطلوب' ,
            'unit'                   => 'حقل الوحدة مطلوب'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMartyrRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name'                   => 'string|required',
            'marital_status'         => 'in:أعزب,متزوج,مطلق,منفصل',
            'martyrdom_date'         => 'date|required',
            'martyrdom_place'        => 'string|required',
            'rank'                   => 'in:جندي,جندي أول,عريف,وكيل عريف,رقيب,رقيب أول,مساعد,مساعد أول,ملازم,ملازم أول,نقيب,رائد,مقدم,عقيد,عميد,لواء,فريق,فريق أول,مشير',
            'force'                  => 'required',
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
            'martyrdom_place'        => 'حقل مكان الاستشهاد مطلوب',
            'rank'                   => 'حقل الرتبة مطلوب',
            'rights'                 => 'حقل حقوق الشهيد مطلوب',
            'record_date'            => 'حقل تاريخ سجل الشهيد مطلوب',
            'unit'                   => 'حقل الوحدة مطلوب'
        ];
    }
}

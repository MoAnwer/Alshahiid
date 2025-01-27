<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\MartyrRequest;
use Illuminate\Http\Request;
use App\Models\Martyr;
use Illuminate\Support\Facades\DB;

class MartyrController extends Controller
{
    public function index()
    {
        
        return view('martyrs.martyrs', [
            'martyrs' => Martyr::with('family.familyMembers.medicalTreatments')->orderByDESC('id')->paginate(15)
        ]);

    }

    public function create()
    {   
        return view('martyrs.create');
    }

    public function store(MartyrRequest $request)
    {

        $data = $request->validated();
        
        try {
            Martyr::create($data);
        } catch (Exception $e) {
            return abort(404, $e->getMessage());
        }

        return to_route('martyrs.index');
    }


    public function edit($id) 
    {
        $martyr  = Martyr::findOrFail($id);
        return view('martyrs.edit', compact('martyr'));
    }


    public function update(Request $request, int $id)
    {
        $data = [];

        if(isset($request->record_number) || isset($request->militarism_number)) {

            $data = $request->validate([
                'name'                   => 'string|required',
                'marital_status'         => 'in:أعزب,متزوج,مطلق,منفصل',
                'martyrdom_date'         => 'date|required',
                'martyrdom_place'        => 'string|required',
                'militarism_number'      => 'sometimes|numeric|unique:martyrs,militarism_number',
                'rank'                   => 'in:جندي,جندي أول,عريف,وكيل عريف,رقيب,رقيب أول,مساعد,مساعد أول,ملازم,ملازم أول,نقيب,رائد,مقدم,عقيد,عميد,لواء,فريق,فريق أول,مشير',
                'force'                  => 'required',
                'record_number'          => 'sometimes|numeric|unique:martyrs,record_number',
                'record_date'            => 'date',
                'unit'                   => 'required|string',
                'rights'                 => 'required|numeric',
            ], [
                'name'                   => 'حقل الاسم مطلوب',
                'martyrdom_date'         => 'حقل تاريخ الاستشهاد مطلوب',
                'martyrdom_place'        => 'حقل مكان الاستشهاد مطلوب',
                'rank'                   => 'حقل الرتبة مطلوب',
                'rights'                 => 'حقل حقوق الشهيد مطلوب',
                'record_number'          => 'حقل رقم السجل  مطلوب',
                'record_date'            => 'حقل تاريخ سجل الشهيد مطلوب',
                'militarism_number'      => 'حقل النمرة العسكرية مطلوب' ,
                'unit'                   => 'حقل الوحدة مطلوب',
                'force'                  => 'حقل القوة اجباري'
            ]);

        } else {
            $data = $request->validate([
            'name'                   => 'string|required',
            'marital_status'         => 'in:أعزب,متزوج,مطلق,منفصل',
            'martyrdom_date'         => 'date|required',
            'martyrdom_place'        => 'string|required',
            'rank'                   => 'in:جندي,جندي أول,عريف,وكيل عريف,رقيب,رقيب أول,مساعد,مساعد أول,ملازم,ملازم أول,نقيب,رائد,مقدم,عقيد,عميد,لواء,فريق,فريق أول,مشير',
            'force'                  => 'required',
            'record_date'            => 'date',
            'unit'                   => 'required|string',
            'rights'                 => 'required|numeric',
        ], [
            'name'                   => 'حقل الاسم مطلوب',
            'martyrdom_date'         => 'حقل تاريخ الاستشهاد مطلوب',
            'martyrdom_place'        => 'حقل مكان الاستشهاد مطلوب',
            'rank'                   => 'حقل الرتبة مطلوب',
            'force'                  => 'حقل القوة اجباري',
            'rights'                 => 'حقل حقوق الشهيد مطلوب',
            'record_date'            => 'حقل تاريخ سجل الشهيد مطلوب',
            'unit'                   => 'حقل الوحدة مطلوب'
        ]);
            
        }

        try {
            //dd($request->all());
            Martyr::findOrFail($id)->update($data);
            return back()->with('success', 'تم الاضافة بنجاح');

        } catch (Exception $e) {
            return abort(404, $e->getMessage());
        }
    }


    public function delete(int $id)
    {
        return view('martyrs.delete', ['martyr' => Martyr::findOrFail($id)]);
    }

    public function destroy(int $id)
    {
        $martyr = Martyr::findOrFail($id);

        $martyr->family->addresses()->delete();

        $martyr->delete();

        return to_route('martyrs.index')->with('success', 'تم حذف بيانات الشهيد بنجاح');
    }

    public function report() 
    {
        $report = Martyr::selectRaw('`force`, COUNT(*) as count')->groupBy('force')->get();
        $report = $report->groupBy('force');
        $totalCount = Martyr::count();
        return view('martyrs.report', compact('report', 'totalCount'));
    }
}
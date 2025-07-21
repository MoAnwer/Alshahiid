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
        $request = request();

        $needel = trim($request->query('needel'));

        $query = DB::table('martyrs')
                ->leftJoin('families', 'families.martyr_id', 'martyrs.id')
                ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                ->select('martyrs.id', 'families.id as family_id', 'families.category as category', 'martyrs.name', 'martyrs.force', 'martyrs.unit', 'martyrs.militarism_number', 'martyrs.martyrdom_date', 'martyrs.martyrdom_place', 'martyrs.record_date', 'martyrs.rights', 'martyrs.record_number', 'martyrs.rank', 'martyrs.family_id as martyr_family_id', 'addresses.sector', 'addresses.locality');

        if($request->query('search') == 'name') {
            $query->where('name', 'LIKE', "%$needel%");
        }

        if($request->query('search') == 'record_number') {
            $query->where('record_number', $needel);
        }

        if (!empty($request->query('force')) && $request->query('force') != 'all') {
            $query->where('force', $request->query('force'));
        }

        if (!empty($request->query('rank')) && $request->query('rank') != 'all') {
            $query->where('rank', $request->query('rank'));
        }

        if (!empty($request->query('martyrdom_date'))) {
            $query->where('martyrdom_date', $request->query('martyrdom_date'));
        }

        if (!empty($request->query('martyrdom_place'))) {
            $query->where('martyrdom_place', 'LIKE', '%' . $request->query('martyrdom_place') . '%' );
        }

        if (!empty($request->query('unit'))) {
            $query->where('unit',  'LIKE', '%' . $request->query('unit') . '%');
        }

        if($request->query('search') == 'militarism_number') {
            $query->where('militarism_number', $needel);
        }

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(martyrs.created_at) as month')->whereMonth('martyrs.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(martyrs.created_at) as year')->whereYear('martyrs.created_at',  $request->query('year'))->groupBy('year');
        } 

        $martyrs = $query->latest('martyrs.id')->paginate();
        
        return view('martyrs.martyrs', ['martyrs' => $martyrs]);

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
            return to_route('martyrs.index')->with('success', 'تم اضافة الشهيد بنجاح ');
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return to_route('martyrs.index');
    }


    public function edit($id) 
    {
        $martyr = Martyr::findOrFail($id);
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
                'militarism_number.required'      => 'حقل النمرة العسكرية مطلوب' ,
                'militarism_number.unique' => 'النمرة العسكرية م  موجودة بالفعل',
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
        try {

             $martyr = Martyr::findOrFail($id);
  

             if(isset($martyr->family) && $martyr->family->addresses->isNotEmpty()) {
                $martyr->family->addresses()->delete();
             }

             if(isset($martyr->family) && $martyr->family->documents->isNotEmpty()) {
                foreach ($martyr->family->documents as $doc)
                {
                    @unlink('uploads/documents/'.$doc->storage_path);
                }
             }  

             if(isset($martyr->family->familyMembers)) {
                foreach ($martyr->family->familyMembers as $member) {
                 
                    @unlink('uploads/images/'.$member->personal_image);

                    if (isset($member->documents)) {
                        foreach ($member->documents as $doc) {
                            
                            @unlink('uploads/members_documents/'.$doc->storage_path);
                        }
                    }
                    
                }
            }



            if(isset($martyr->martyrDoc->storage_path)) {
                @unlink(public_path("uploads/documents/{$martyr->martyrDoc->storage_path}"));
                $martyr->martyrDoc()->delete();
            }

            $martyr->delete();

            return to_route('martyrs.index')->with('success', 'تم حذف بيانات الشهيد بنجاح'); 
              
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }


    public function relateToFamilyPage(int $martyr) 
    {
        $martyr = Martyr::findOrFail($martyr);
        return view('martyrs.relateToFamily', compact('martyr'));
    }

    public function relateToFamilyAction(Request $request, int $martyr) 
    {
        $data = $request->validate([
            'family_id' => 'required|numeric|exists:families,id'
        ], [
            'family_id.required' => 'معرف الاسرة مطلوب لعملية الربط',
            'family_id.exists' => 'معرف الاسرة المدخل غير موجود !'
        ]);

        try {

            Martyr::findOrFail($martyr)->update(['family_id' => $data['family_id']]);
            return back()->with('success', 'تم ربط الشهيد بالاسرة ذات المعرف ' . $data['family_id'] . ' بنجاح ');

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function report() 
    {
        $request = request();

        $query = DB::table('martyrs')
                ->leftJoin('families', 'families.martyr_id', 'martyrs.id')
                ->leftJoin('addresses', 'families.id', 'addresses.family_id')
                ->selectRaw('martyrs.force, COUNT(martyrs.force) as count')->groupBy('martyrs.force');

        
        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector', 'martyrs.force']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->selectRaw('addresses.locality as locality')->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'martyrs.force']);
        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(martyrs.created_at) as month')->whereMonth('martyrs.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(martyrs.created_at) as year')->whereYear('martyrs.created_at',  $request->query('year'))->groupBy('year');
        } 

        $report = $query->get()->groupBy('force'); 

        return view('martyrs.report', compact('report'));
    }
    
}
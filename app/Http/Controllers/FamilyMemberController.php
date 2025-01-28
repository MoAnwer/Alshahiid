<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Family;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;


class FamilyMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $family)
    {  
        try {

            $family = Family::findOrFail($family);

            return view('familyMembers.create', compact('family'));

        } catch(Exception $e) {

            return abort(404);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $family)
    {
		$data = $request->validate([
                "name" => 'string|required',
                "age" => 'integer|required',
                "gender" => "in:ذكر,أنثى",
                "relation" => "in:اب,ام,اخ,اخت,زوجة,ابن,ابنة",
                "national_number" => "required|numeric|unique:family_members,national_number",
                "phone_number" => "string|nullable",
                "birth_date" => "date|required",
                "health_insurance_number" => "numeric|nullable|unique:family_members,health_insurance_number",
                "health_insurance_start_date" => "date|nullable",
                "health_insurance_end_date" => "date|nullable",
                'personal_image' => 'image:mimes:jpg,png,jpeg,gif|nullable',
            ], [
                'name'              => 'حقل الاسم اجباري',
                'age'               => 'حقل العمر اجباري' ,
                'national_number'   => 'الرقم الوطني اجباري',
                'birth_date'        => 'تاريخ الميلاد اجباري',
                'health_insurance_number.unique'   => 'رقم بطاقة التأمين الصحي  موجود بالفعل',
                'national_number.unique'   => 'الرقم الوطني موجود بالفعل',
            ]);

        try {
        
            $family = Family::find($family);

            if($request->hasFile('personal_image')) {
                $imageName = str()->orderedUuid() . '.' . $request->file('personal_image')->getClientOriginalExtension();
                $request->file('personal_image')->move(public_path('uploads/images'), $imageName);

                $data['personal_image'] = $imageName;

                $family->familyMembers()->create($data);
                
                return back()->with('success', 'تم اضافة الفرد بنجاح');
            }

            $family->familyMembers()->create($data);
        
            return back()->with('success', 'تم اضافة الفرد بنجاح');

        } catch (Exception $e) {
            return $e->getMessage();
        }
     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $member = Cache::remember('member', now()->addMinutes(10), function() use ($id) {
                return FamilyMember::findOrFail($id);
            });
            return view('familyMembers.show', compact('member'));

        } catch (Exception $e) {
            return $e->getMessage();
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $family, int $member)
    {
        try {

            $family = Family::findOrFail($family);
            $familyMember = Cache::remember('familyMember_forEdit', now()->addMinutes(10), function() use ($member) {
                return $family->familyMembers->find($member);
            });
            return view('familyMembers.edit', compact('familyMember'));

        } catch (Exception $e) {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [];

        if(isset($request->national_number) && isset($request->health_insurance_number)) {
		$data = $request->validate([
                "name" => 'string|required',
                "age" => 'integer|required',
                "gender" => "in:ذكر,أنثى",
                "relation" => "in:اب,ام,اخ,اخت,زوجة,ابن,ابنة",
                "national_number" => "required|numeric|unique:family_members,national_number",
                "phone_number" => "string|nullable",
                "birth_date" => "date|required",
                "health_insurance_number" => "numeric|nullable|unique:family_members,health_insurance_number",
                "health_insurance_start_date" => "date|nullable",
                "health_insurance_end_date" => "date|nullable",
                'personal_image' => 'image:mimes:jpg,png,jpeg,gif|nullable',
            ], [
                'name'              => 'حقل الاسم اجباري',
                'age'               => 'حقل العمر اجباري' ,
                'national_number'   => 'الرقم الوطني اجباري',
                'birth_date'        => 'تاريخ الميلاد اجباري',
                'health_insurance_number.unique'   => 'رقم بطاقة التأمين الصحي  موجود بالفعل',
                'national_number.unique'   => 'الرقم الوطني موجود بالفعل',
            ]);
        } else if(isset($request->national_number)) {
            $data = $request->validate([
                "name" => 'string|required',
                "age" => 'integer|required',
                "gender" => "in:ذكر,أنثى",
                "relation" => "in:اب,ام,اخ,اخت,زوجة,ابن,ابنة",
                "national_number" => "required|numeric|unique:family_members,national_number",
                "phone_number" => "string|nullable",
                "birth_date" => "date|required",
                "health_insurance_start_date" => "date|nullable",
                "health_insurance_end_date" => "date|nullable",
                'personal_image' => 'image:mimes:jpg,png,jpeg,gif|nullable',
            ], [
                'name'              => 'حقل الاسم اجباري',
                'age'               => 'حقل العمر اجباري' ,
                'national_number'   => 'الرقم الوطني اجباري',
                'birth_date'        => 'تاريخ الميلاد اجباري',
                'national_number.unique'   => 'الرقم الوطني موجود بالفعل',
            ]);
        } else if (isset($request->health_insurance_number)) {
            $data = $request->validate([
                "name" => 'string|required',
                "age" => 'integer|required',
                "gender" => "in:ذكر,أنثى",
                "relation" => "in:اب,ام,اخ,اخت,زوجة,ابن,ابنة",
                "phone_number" => "string|nullable",
                "birth_date" => "date|required",
                "health_insurance_number" => "numeric|nullable|unique:family_members,health_insurance_number",
                "health_insurance_start_date" => "date|nullable",
                "health_insurance_end_date" => "date|nullable",
                'personal_image' => 'image:mimes:jpg,png,jpeg,gif|nullable',
            ], [
                'name'              => 'حقل الاسم اجباري',
                'age'               => 'حقل العمر اجباري' ,
                'national_number'   => 'الرقم الوطني اجباري',
                'birth_date'        => 'تاريخ الميلاد اجباري',
                'health_insurance_number.unique'   => 'رقم بطاقة التأمين الصحي  موجود بالفعل',
                'national_number.unique'   => 'الرقم الوطني موجود بالفعل',
            ]);
        } else {
            $data = $request->validate([
                "name" => 'string|required',
                "age" => 'integer|required',
                "gender" => "in:ذكر,أنثى",
                "relation" => "in:اب,ام,اخ,اخت,زوجة,ابن,ابنة",
                "phone_number" => "string|nullable",
                "birth_date" => "date|required",
                "health_insurance_start_date" => "date|nullable",
                "health_insurance_end_date" => "date|nullable",
                'personal_image' => 'image:mimes:jpg,png,jpeg,gif|nullable',
            ], [
                'name'              => 'حقل الاسم اجباري',
                'age'               => 'حقل العمر اجباري' ,
                'national_number'   => 'الرقم الوطني اجباري',
                'birth_date'        => 'تاريخ الميلاد اجباري',
                'health_insurance_number.unique'   => 'رقم بطاقة التأمين الصحي  موجود بالفعل',
                'national_number.unique'   => 'الرقم الوطني موجود بالفعل',
            ]); 
        }
			
        try {

            $familyMember = FamilyMember::find($id);
            
            if($request->hasFile('personal_image')) {

                unlink(public_path('uploads/images/'.$familyMember->personal_image));
                

                $imageName = str()->orderedUuid() . '.' . $request->file('personal_image')->getClientOriginalExtension();                

                $request->file('personal_image')->move(public_path('uploads/images'), $imageName);

                $data['personal_image'] = $imageName;

                $familyMember->update($data);
                
                return back()->with('success', 'تم تعديل  بيانات الفرد بنجاح');
            }

            $familyMember->update($data);
        
            return to_route('families.show', $familyMember->family->id)->with('success', 'تم تعديل  بيانات الفرد بنجاح');

        } catch (Exception $e) {
            return $e->getMessage();
        }

    }
	
	
	public function delete(int $id) 
	{
		return view('familyMembers.delete', ['member' => 
            FamilyMember::findOrFail($id)
        ]);
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $familyMember = FamilyMember::findOrFail($id);
            $familyId = $familyMember->family->id;
            unlink(public_path('uploads/images/'.$familyMember->personal_image));
            $familyMember->delete();
            return to_route('families.show', $familyId)->with('success', 'تم حذف الفرد بنجاح');
        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function familyMembersCountReport()
    {
        $request = request();

        $report = null;

        if(($sector = $request->query('sector')) && ($locality = $request->query('locality'))) {
            $report = 
            Cache::remember('report_sector_' .$sector.'_locality_'.$locality , now()->addMinutes(10), function () use ($sector, $locality) {
                return collect(DB::select('
                                SELECT 
                                    m.relation, 
                                    COUNT(m.id) as count,
                                    a.sector,
                                    a.locality 
                                FROM
                                    family_members m
                                INNER JOIN
                                    addresses  a
                                ON
                                    a.family_id = m.family_id 
                                WHERE 
                                    a.sector = ?
                                AND 
                                    a.locality = ?
                                GROUP BY
                                    m.relation, a.sector, a.locality
                        ', [$sector, $locality]
                ));
            });
        } else {
            $report = Cache::remember('report', now()->addMinutes(10), function() {
                return FamilyMember::selectRaw('relation, count(id) as count')->groupBy('relation')->get();
            });
        }
        
        $report = $report->groupBy('relation');


        $totalCount = Cache::remember('count', now()->addMinutes(10), function() {
            return FamilyMember::count();
        });
        

        return view('reports.familyMemebersCountReport', compact('report', 'totalCount'));
    }


    public function familyMembersCountByCategoryReport()
    {
        $request = request();

        $report = null;

        if(($sector = $request->query('sector')) && ($locality = $request->query('locality'))) {
            $report = collect(DB::select('
                            SELECT 
                                a.sector,
                                a.locality,
                                f.family_size
                            FROM
                                families f
                            INNER JOIN
                                addresses  a
                            ON
                                a.family_id = f.id 
                            WHERE
                                a.sector = ?
                            AND
                                a.locality = ?
                            GROUP BY family_size

                    '
            ), [$sector, $locality]);
        } else {
            $report = Family::selectRaw('family_size, count(family_size) as count')->groupBy('family_size')->get();
        }

        $report = $report->groupBy('family_size');

        return view('reports.familyMembersCountByCategoryReport', compact('report'));
    }

}

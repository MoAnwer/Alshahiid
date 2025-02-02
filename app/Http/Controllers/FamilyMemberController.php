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

    public function create(int $family)
    {  
        try {

            $family = Family::findOrFail($family);

            return view('familyMembers.create', compact('family'));

        } catch(Exception $e) {

            return $e->getMessage();
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

    public function show(int $id)
    {
        try {
            $member = FamilyMember::findOrFail($id);
            return view('familyMembers.show', compact('member'));
        } catch (Exception $e) {
            return $e->getMessage();
            return abort(404);
        }
    }

    public function edit(int $family, int $member)
    {
        try {

            $family = Family::findOrFail($family);
            $familyMember = $family->familyMembers->find($member);
            return view('familyMembers.edit', compact('familyMember'));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

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

                @unlink(public_path('uploads/images/'.$familyMember->personal_image));
                

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
		return view('familyMembers.delete', ['member' => FamilyMember::findOrFail($id)]);
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
            @unlink(public_path('uploads/images/'.$familyMember->personal_image));
            $familyMember->delete();
            return to_route('families.show', $familyId)->with('success', 'تم حذف الفرد بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function familyMembersCountReport()
    {
        $request = request();

        $report = null;

        if(($sector = $request->query('sector')) && ($locality = $request->query('locality'))) {
            $report = 
            Cache::remember('report_sector_' .$sector.'_locality_'.$locality , now()->addMinutes(1), function () use ($sector, $locality) {
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
            $report = Cache::remember('report', now()->addMinutes(1), function() {
                return FamilyMember::selectRaw('relation, count(id) as count')->groupBy('relation')->get();
            });
        }
        
        $report = $report->groupBy('relation');


        $totalCount = Cache::remember('count_of_members_cache', now()->addMinutes(1), function() {
            return FamilyMember::count();
        });
        

        return view('reports.familyMemebersCountReport', compact('report', 'totalCount'));
    }


    public function familyMembersCountByCategoryReport()
    {
        $request = request();

        $report = null;
        $moreTenMembersQuery = null;

        if(($sector = $request->query('sector')) && ($locality = $request->query('locality'))) {
            $report = collect(DB::select('
                            SELECT 
                                a.sector,
                                a.locality,
                                f.family_size,
                                count(f.family_size) as count
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
                            GROUP BY f.family_size, a.locality,  a.sector

                    '
            , [$sector, $locality]));


        $moreTenMembersQuery = collect(DB::select('
                            SELECT 
                                a.sector,
                                a.locality,
                                f.family_size,
                                count(f.family_size) as count
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
                            AND 
                                f.family_size > 10
                            GROUP BY f.family_size, a.locality,  a.sector
                    '
            , [$sector, $locality]));


        } else {
            $report = Family::selectRaw('family_size, count(family_size) as count')->groupBy('family_size')->get();
            $moreTenMembersQuery = 
            collect(Family::selectRaw('family_size, count(family_size) as count')->where('family_size', '>', 10)->groupBy('family_size')->get());
        }

        $moreTenMembersCount = 0;

        foreach ($moreTenMembersQuery as $value) {
            $moreTenMembersCount++;
        }

        $report = $report->groupBy('family_size');

        return view('reports.familyMembersCountByCategoryReport', compact('report', 'moreTenMembersCount'));
    }


    public function orphanReport()
    {
        $request = request();

        $report = null;
        $orphanReportQuery = null;

        if(($sector = $request->query('sector')) && ($locality = $request->query('locality'))) {
            $report = collect(DB::select('
                            SELECT 
                                a.sector,
                                a.locality,
                                f.gender,
                                COUNT(CASE WHEN f.age < 5 THEN 1 END)  AS "ander5",
                                COUNT(CASE WHEN f.age BETWEEN 6 AND 12 THEN 1 END) AS "from6To12",
                                COUNT(CASE WHEN f.age BETWEEN 13 AND 16 THEN 1 END) AS "from13To16",
                                COUNT(CASE WHEN f.age BETWEEN 17 AND 18 THEN 1 END) AS "from17To18",
                                COUNT(CASE WHEN f.gender = "ذكر" AND f.relation = "ابن" AND f.age <= 18 THEN 1 END) AS "countOfMales",
                                COUNT(CASE WHEN f.gender = "أنثى" AND f.relation = "ابنة" AND f.age <= 18 THEN 1 END) AS "countOfFemales",
                                COUNT(CASE WHEN f.gender = "أنثى" AND f.relation = "زوجة" THEN 1 END) AS "countOfWidow"
                            FROM
                                family_members f
                            INNER JOIN 
                                addresses a
                            ON
                                a.family_id = f.family_id 
                            WHERE
                                a.sector = ?
                            AND
                                a.locality = ?
                            AND (
                                f.relation = "ابن"
                            OR
                                f.relation = "ابنة"
                            )
                            GROUP BY 
                                a.locality,  a.sector, f.gender

                    '
            , [$sector, $locality]));

            $report = $report->groupBy('gender');


            $countOfWidow = DB::select(
                'SELECT 
                    a.sector,
                    a.locality,
                    COUNT(CASE WHEN f.gender = "أنثى" AND f.relation = "زوجة" THEN 1 END) AS "countOfWidow"  
                FROM 
                    family_members f
                INNER JOIN 
                    addresses a
                ON
                    a.family_id = f.family_id 
                WHERE
                    a.sector = ?
                AND
                    a.locality = ?
                GROUP BY 
                    a.locality,  a.sector
                
            ', [$sector, $locality]);

            $countOfWidow = (@$countOfWidow[0]->countOfWidow ?? 0);

            //dd($countOfWidow);


            $totalCountOfMembers = 
                (@$report->get('ذكر')[0]->countOfMales  ?? 0) + (@$report->get('أنثى')[0]->countOfFemales ?? 0) + ($countOfWidow);


            return view('reports.orphanReport', compact('report', 'countOfWidow', 'totalCountOfMembers'));
        }

        $report = collect(DB::select('
                            SELECT 
                                f.gender,
                                COUNT(CASE WHEN f.age < 5 THEN 1 END)  AS "ander5",
                                COUNT(CASE WHEN f.age BETWEEN 6 AND 12 THEN 1 END) AS "from6To12",
                                COUNT(CASE WHEN f.age BETWEEN 13 AND 16 THEN 1 END) AS "from13To16",
                                COUNT(CASE WHEN f.age BETWEEN 17 AND 18 THEN 1 END) AS "from17To18",
                                COUNT(CASE WHEN f.gender = "ذكر" AND f.relation = "ابن" AND f.age <= 18 THEN 1 END) AS "countOfMales",
                                COUNT(CASE WHEN f.gender = "أنثى" AND f.relation = "ابنة" AND f.age <= 18 THEN 1 END) AS "countOfFemales"
                            FROM
                                family_members f
                            WHERE
                                f.relation = "ابن"
                            OR
                                f.relation = "ابنة"
                            GROUP BY f.gender'
        ));

        $report = $report->groupBy('gender');

        $countOfWidow = DB::select('SELECT COUNT(CASE WHEN f.gender = "أنثى" AND f.relation = "زوجة" THEN 1 END) AS "countOfWidow"  FROM family_members f');
        $countOfWidow = $countOfWidow[0]->countOfWidow;

        
        $totalCountOfMembers = (@$report->get('ذكر')[0]->countOfMales  ?? 0) + (@$report->get('أنثى')[0]->countOfFemales ?? 0) + ($countOfWidow);

        return view('reports.orphanReport', compact('report', 'countOfWidow',  'totalCountOfMembers'));

    }


}

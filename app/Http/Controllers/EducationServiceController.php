<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Student;
use App\Models\EducationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EducationServiceController extends Controller
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


    public function create(int $member)
    {
		$student = Student::findOrFail($member);
        return view('educationServices.create', compact('student'));
    }


    public function store(Request $request, int $member)
    {
        $data = $request->validate([
            'type'              => 'required|in:زي و أدوات,رسوم دراسية,تأهيل مهني,تأهيل نسوي,تكريم متفوقين,دراسات عليا,إعانات طلاب,دورات رفع المستويات',
            'status'            => 'required|in:مطلوب,منفذ',
            'budget'            => 'numeric|required',
            'budget_from_org'   => 'required|numeric',
            'budget_out_of_org' => 'required|numeric',           
            'notes'             => 'nullable|string',
            'provider'          => 'in:من داخل المنظمة,من خارج المنظمة'
        ], [
            'budget'            => 'حقل المبلغ مطلوب',
            'budget_from_org'            => '[اضف 0 اذا لم يكن هناك مبلغ] حقل المبلغ من داخل المنظمة مطلوب',
            'budget_out_of_org'            => '[اضف 0 اذا لم يكن هناك مبلغ] حقل المبلغ من خارج المنظمة',
            
        ]);

        $student = Student::findOrFail($member);

        try {
            $student->educationServices()->create($data);
            return back()->with('success', 'تم إضافة الخدمة التعليمية بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
    }

    public function edit(int $id)
    {
        $service = EducationService::findOrFail($id);
        return view('educationServices.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EducationService  $educationService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'type'              => 'required|in:زي و أدوات,رسوم دراسية,تأهيل مهني,تأهيل نسوي,تكريم متفوقين,دراسات عليا,إعانات طلاب,دورات رفع المستويات',
            'status'            => 'required|in:مطلوب,منفذ',
            'budget'            => 'numeric|required',
            'budget_from_org'   => 'required|numeric',
            'budget_out_of_org' => 'required|numeric',           
            'notes'             => 'nullable|string',
            'provider'          => 'in:من داخل المنظمة,من خارج المنظمة'
        ], [
            'budget'            => 'حقل المبلغ مطلوب',
            'budget_from_org'            => '[اضف 0 اذا لم يكن هناك مبلغ] حقل المبلغ من داخل المنظمة مطلوب',
            'budget_out_of_org'            => '[اضف 0 اذا لم يكن هناك مبلغ] حقل المبلغ من خارج المنظمة',
        ]);

        $service = EducationService::findOrFail($id);

        try {
            $service->update($data);

            return back()->with('success', 'تم تعديل الخدمة بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete(int $id)
    {
       return view('educationServices.delete', ['service' => EducationService::findOrFail($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EducationService  $educationService
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $service = EducationService::findOrFail($id);
        $studentId = $service->student->id;
        $service->delete();

        return to_route('students.show', $studentId)->with('success', 'تم حذف الخدمة التعليمية بنجاح');
    }

    public function report()
    {
        $report = null;

        // if(($sector  = request()->query('sector')) && ($locality  = request()->query('locality'))) {
        //     $report = collect(
        //         DB::select('
        //             SELECT 
        //                 e.type,
        //                 e.status,
        //                 count(e.id) as count,
        //                 SUM(e.budget) as budget, 
        //                 SUM(e.budget_from_org) as budget_from_org, 
        //                 SUM(e.budget_out_of_org) as budget_out_of_org,
        //                 a.sector,
        //                 a.locality
        //             FROM 
        //                 education_services e
        //             INNER JOIN
        //                 students s
        //             ON 
        //                 s.id = e.student_id
        //             INNER JOIN
        //                 family_members fm
        //             ON 
        //                 fm.id = s.family_member_id
        //             INNER JOIN
        //                 addresses a
        //             ON 
        //                 a.family_id = fm.family_id
        //             WHERE
        //                 a.sector = ?
        //             AND 
        //                 a.locality = ?
        //             GROUP BY
        //                 e.type, e.status, a.sector,  a.locality
                    
        //         ', [$sector, $locality])
        //     );
        // }

        $report  = EducationService::selectRaw('type, status, count(*) as count, SUM(budget) as budget, SUM(budget_from_org) as budget_from_org, SUM(budget_out_of_org) as budget_out_of_org')->groupBy(['type', 'status'])->get();

		$report = $report->groupBy(['type', 'status']);


        return view('reports.eduction', compact('report'));
    }
}

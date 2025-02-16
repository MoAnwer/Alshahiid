<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Student;
use App\Models\EducationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EducationServiceController extends Controller
{


    public function index()
    {
        $request = request();

        $needel = trim(htmlentities($request->query('needel')));

        $query = DB::table('family_members')
                ->join('families', 'family_members.family_id', '=', 'families.id')
                ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                ->join('students', 'students.family_member_id', '=', 'family_members.id')
                ->join('education_services', 'education_services.student_id', '=', 'students.id')
                ->leftJoin('martyrs', 'martyrs.id', '=', 'families.martyr_id')
                ->select(
                    'addresses.sector as sector',
                    'addresses.locality as locality',
                    'families.martyr_id',
                    'families.id as family_id',
                    'martyrs.name as martyr_name',
                    'martyrs.force as force',
                    'family_members.id as orphan_id',
                    'education_services.type as type',
                    'education_services.created_at as created_at',
                    'students.stage as stage',
                    'students.class as class',
                    'education_services.id as service_id',
                    'education_services.status as status',
                    'education_services.budget as budget',
                    'education_services.budget_from_org as budget_from_org',
                    'education_services.budget_out_of_org as budget_out_of_org',
                    'family_members.name as name',
                    'family_members.gender as gender',
                    'family_members.relation as relation',
                    'family_members.family_id as family_id'
                );


        if ($request->query('search') == 'name') {
            $query->where('family_members.name', 'LIKE', "%$needel%");
        }

        if ($request->query('search') == 'martyr_name') {
            $query->where('martyrs.name', $needel);
        }

        if ($request->query('search') == 'militarism_number') {
            $query->where('martyrs.militarism_number', $needel);
        }
        

        if (!empty($request->query('stage')) && $request->query('stage') != 'all') {
            $query->where('students.stage', $request->query('stage'));
        } 

        if ($request->query('search') == 'class') {
            $query->where('students.class', $needel);
        }

        if ($request->query('search') == 'force') {
            $query->where('martyrs.force', $needel);
        }

        if (!empty($request->query('gender')) && $request->query('gender') != 'all') {
            $query->where('family_members.gender', $request->query('gender'));
        } 

        if (!empty($request->query('relation')) && $request->query('relation') != 'all') {
            $query->where('family_members.relation', $request->query('relation'));
        } 

        if (!empty($request->query('type')) && $request->query('type') != 'all') {
            $query->where('education_services.type', $request->query('type'));
        } 

        if (!empty($request->query('status')) && $request->query('status') != 'all') {
            $query->where('education_services.status', $request->query('status'));
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        if (!empty($request->query('year')) && $request->query('year') != 'all') {
            $query->whereYear('education_services.created_at', $request->query('year'));
        } 

         if (!empty($request->query('month')) && $request->query('month') != 'all') {
            $query->whereMonth('education_services.created_at', $request->query('month'));
        } 


        $educationServices = $query->latest('education_services.id')->paginate();

        return view('educationServices.index', compact('educationServices'));
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
        $request = request();

        $query = DB::table('education_services')
                ->join('students', 'students.id', 'education_services.student_id')
                ->join('family_members', 'family_members.id', 'students.family_member_id')
                ->join('families', 'families.id', 'family_members.family_id')
                ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                ->selectRaw('
                    education_services.status as status,
                    education_services.type as type,
                    SUM(education_services.budget) as  budget,  
                    SUM(education_services.budget_from_org) as budget_from_org,
                    SUM(education_services.budget_out_of_org)  as budget_out_of_org,                   
                    SUM(education_services.budget_out_of_org + education_services.budget_from_org)  as totalMoney,
                    COUNT(education_services.status) as count
                ', 
                )->groupBy(['education_services.status', 'education_services.type']);


        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector', 'education_services.status', 'education_services.type']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->selectRaw('addresses.locality as locality')->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'education_services.status', 'education_services.type']);
        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(education_services.created_at) as month')->whereMonth('education_services.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(education_services.created_at) as year')->whereYear('education_services.created_at',  $request->query('year'))->groupBy('year');
        } 

        $report = $query->latest('education_services.created_at')->get()->groupBy(['type', 'status']); 

        return view('reports.eduction', compact('report'));
    }
}

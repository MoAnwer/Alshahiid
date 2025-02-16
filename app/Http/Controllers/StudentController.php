<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Models\FamilyMember;
use App\Services\StudentService;
use Illuminate\Support\Facades\{Log, DB};

class StudentController extends Controller
{

    protected $log;
    protected Student $student;
    protected FamilyMember $member;
    protected StudentService $studentService;

    public function __construct()
    {
        $this->student = new Student;
        $this->member = new FamilyMember;
        $this->studentService = new StudentService;
        $this->log  = Log::stack(['stack' => Log::build(['driver' => 'single', 'path' => storage_path('logs/alshahiid.log')]) ]);
    }

    /**
     * students list
     *
     * @return View
     **/

    public function index()
    {

        $request = request();

        $query = DB::table('family_members')
                ->join('families', 'family_members.family_id', '=', 'families.id')
                ->join('addresses', 'addresses.family_id', 'families.id')
                ->join('students', 'students.family_member_id', '=', 'family_members.id')
                ->join('martyrs', 'martyrs.id', '=', 'families.martyr_id')
                ->select(
                    'addresses.sector as sector',
                    'addresses.locality as locality',
                    'families.martyr_id',
                    'families.id as family_id',
                    'martyrs.name as martyr_name',
                    'martyrs.force as force',
                    'students.stage as stage',
                    'students.class as class',
                    'students.school_name as school_name',
                    'family_members.name as name',
                    'family_members.gender as gender',
                    'family_members.relation as relation',
                    'family_members.family_id as family_id'
                );

        $needel = trim(htmlentities($request->query('needel')));

        if ($request->query('search') == 'name') {
            $query->where('family_members.name', 'LIKE', "%{$needel}%");
        }

        if ($request->query('search') == 'martyr_name') {
            $query->where('martyrs.name', 'LIKE', "%{$needel}%");
        }

        if ($request->query('search') == 'force') {
            $query->where('martyrs.force', 'LIKE', "%{$needel}%");
        }

        if ($request->query('search') == 'militarism_number') {
            $query->where('martyrs.militarism_number', $needel);
        }
        

        if(!empty($request->query('gender')) && $request->query('gender') != 'all') {
            $query->where('family_members.gender', $request->query('gender'));
        }

        if(!empty($request->query('relation')) && $request->query('relation') != 'all') {
            $query->where('family_members.relation', $request->query('relation'));
        }

        if(!empty($request->query('stage')) && $request->query('stage') != 'all') {
            $query->where('students.stage', $request->query('stage'));
        }

        if($request->query('search') == 'class') {
            $query->where('students.class', 'LIKE', "%$needel%");
        }

        if($request->query('search') == 'school_name') {
            $query->where('students.school_name', 'LIKE', "%$needel%");
        }

        if($request->query('search') == 'force') {
            $query->where('martyrs.force', 'LIKE', "%$needel%");
        }

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        $students = $query->latest('martyrs.id')->paginate(); 

        return view('students.index', compact('students'));
    }



    public function create(int $member)
    {
        return view('students.create', ['member' => $this->member->findOrFail($member)]);
    }

    public function store(StudentRequest $request, int $member)
    {
        $data = $request->validated();

        try {
            $student = $this->member->findOrFail($member)->student()->create($data);
            return to_route('students.show', $student->id);
            
        } catch (Exception $e) {
            $this->log->error('Storing student member id='. $member, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }


    public function show(int $student)
    {
        return view('students.show', ['student' => $this->student->findOrFail($student)]);
    }


    public function edit($id)
    {
        return view('students.edit', ['student' => $this->student->findOrFail($id)]);
    }

    public function update(StudentRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $this->student->findOrFail($id)->update($data);
            return back()->with('success', 'تم التعديل بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        return view('students.delete', ['student' => $this->student->findOrFail($id)]);
    }

    public function destroy($id)
    {
        $student = $this->student->findOrFail($id);
        $memberId = $student->familyMember->id;
        $student->delete();
        return to_route('familyMembers.show', $memberId)->with('success', 'تم حذف الملف التعليمي بنجاح');
    }

    public function report()
    {
        return view('reports.studentsReport', $this->studentService->report());
    }

}

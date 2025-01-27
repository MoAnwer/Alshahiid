<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
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
    public function create(int $member)
    {
        return view('students.create', ['member' => FamilyMember::findOrFail($member)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request, int $member)
    {
        $data = $request->validated();

        try {
            $student = FamilyMember::findOrFail($member)->student()->create($data);
            return to_route('students.show', $student->id);
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function show(int $student)
    {
        return view('students.show', ['student' => Student::findOrFail($student)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('students.edit', ['student' => Student::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, $id)
    {
        $data = $request->validated();

        try {
            Student::findOrFail($id)->update($data);
            return back()->with('success', 'تم التعديل بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        return view('students.delete', ['student' => Student::findOrFail($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $memberId = $student->familyMember->id;
        $student->delete();
        return to_route('familyMembers.show', $memberId)->with('success', 'تم حذف الملف التعليمي بنجاح');
    }


    public function report()
    {
        $request = request();

        $report = null;

        if(($sector = $request->query('sector')) && ($locality = $request->query('locality'))) {
            $report = collect(DB::select('
                            SELECT 
                                a.sector,
                                a.locality,
                                s.stage,
                                COUNT(*) as count,
                                a.sector,
                                a.locality
                            FROM
                                students s
                            INNER JOIN
                                family_members  m
                            ON
                                s.family_member_id = m.id 
                            INNER JOIN 
                                addresses a
                            ON
                                a.family_id = m.family_id
                            WHERE
                                a.sector = ?
                            AND
                                a.locality = ?
                            GROUP BY 
                                stage, a.sector, a.locality

                    '
            , [$sector, $locality]));
        } else {
            $report = Student::selectRaw('stage, COUNT(*) as count')->groupBy('stage')->get();
        }
        

        $report  = $report->groupBy('stage');

        return view('reports.studentsReport', compact('report'));
    }
}

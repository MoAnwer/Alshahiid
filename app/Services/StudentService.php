<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class StudentService 
{
    public function report()
    {
        $request = request();

        $query = DB::table('students')
                ->join('family_members', 'family_members.id', 'students.family_member_id')
                ->join('families', 'families.id', 'family_members.family_id')
                ->join('addresses', 'addresses.family_id', 'families.id')
                ->selectRaw('
                    COUNT(students.stage) AS count,
                    family_members.gender AS gender 
                '
                )->groupBy('family_members.gender');

        if (!empty($request->query('gender')) && $request->query('gender') != 'all') {
            $query->where('family_members.gender', $request->query('gender'))->groupBy('family_members.gender');
        } 

        if (!empty($request->query('stage')) && $request->query('stage') != 'all') {
            $query->selectRaw('students.stage as stage')->where('students.stage', $request->query('stage'))
            ->groupBy(['addresses.sector', 'students.stage', 'family_members.gender']);
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector', 'students.stage', 'family_members.gender']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->selectRaw('addresses.locality as locality')->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'students.stage', 'family_members.gender']);
        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(students.created_at) as month')->whereMonth('students.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(students.created_at) as year')->whereYear('students.created_at',  $request->query('year'))->groupBy('year');
        } 

        $report = $query->get()->groupBy('gender');

        // dd($report);

        return compact('report');
    }
}
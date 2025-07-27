<?php

namespace App\Services;

use App\Models\FamilyMember;
use App\Models\Family;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class FamilyMemberService 
{
    public function familyMembersCountReport()
    {
        $request = request();

        $report = null;

        $sector = $request->query('sector');
        $locality   = $request->query('locality');

        $query = DB::table('family_members')
                ->join('addresses', 'addresses.family_id', 'family_members.family_id')
                ->selectRaw('
                    family_members.relation, 
                    COUNT(family_members.id) as count
                ')
                ->groupBy('family_members.relation');


        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality']);
        } 



        $report =  $query->get();
        
        $report = $report->groupBy('relation');

        // dd($report);


        // $totalCount = FamilyMember::count();

        return ['report' => $report]; //, 'totalCount' => $totalCount
    }






    public function familyMembersCountByCategoryReport()
    {
  
        $request = request();

        $query = DB::table('families')
                ->join('addresses', 'addresses.family_id', 'families.id')
                ->selectRaw('families.family_size as family_size, COUNT(families.id) as count')
                ->groupBy('families.family_size');

        $moreTenMembersQuery = DB::table('families')
                               ->join('addresses', 'addresses.family_id', 'families.id')
                               ->selectRaw('families.family_size, count(families.family_size) as count')
                               ->where('families.family_size', '>', 10)->groupBy('families.family_size');

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector', 'families.family_size']);

            $moreTenMembersQuery->selectRaw('addresses.sector as sector')->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector', 'families.family_size']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {

            $query->selectRaw('addresses.locality as locality')->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'families.family_size']);


            $moreTenMembersQuery->selectRaw('addresses.locality as locality')->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'families.family_size']);

        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(families.created_at) as month')->whereMonth('families.created_at',  $request->query('month'))->groupBy('month');
            $moreTenMembersQuery->selectRaw('MONTH(families.created_at) as month')->whereMonth('families.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(families.created_at) as year')->whereYear('families.created_at',  $request->query('year'))->groupBy('year');
            $moreTenMembersQuery->selectRaw('YEAR(families.created_at) as year')->whereYear('families.created_at',  $request->query('year'))->groupBy('year');
        } 

        $report = $query->get()->groupBy('family_size'); 

        $moreTenMembersQuery = $moreTenMembersQuery->get();

        $moreTenMembersCount = 0;

        foreach ($moreTenMembersQuery as $value) {
            $moreTenMembersCount+= $value->count;
        }


        return ['report' => $report, 'moreTenMembersCount' => $moreTenMembersCount];
    }

    
    /**
     * Orphan report
     * @return array
     */

    public function orphanReport()
    {
        $request = request();

        $report = null;
        $orphanReportQuery = null;

        $from = $request->query('from');
        

        $query = DB::table('family_members')
                ->join('families', 'family_members.family_id', 'families.id')
                ->join('addresses', 'addresses.family_id', 'families.id')
                ->selectRaw('family_members.gender')
                ->where('family_members.age', '<=', 18)->where('family_members.relation',  "ابن")->orWhere('family_members.relation',  "ابنة")
                ->groupBy(['family_members.gender']);

        if ($request->query('age') == 'all' || is_null($request->query('age'))) {
            $query->selectRaw('COUNT(family_members.age) as count')->groupBy(['family_members.gender']);
        }

        if ($request->query('age') != 'all' && $request->query('age') == 'under5') {
            $query->selectRaw('count(family_members.age) as count')->whereBetween('family_members.age', [0, 5])->groupBy(['family_members.gender']);
        }

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        $report = $query->get()->groupBy('gender');
        $totalMale =  @($report->get('ذكر') == null ? 0 : $report->get('ذكر')->sum('count'));
        $totalFemale = @($report->get('أنثى') == null ? 0 : $report->get('أنثى')->sum('count'));

        return ['report' => $report, 'totalMale' => $totalMale, 'totalFemale' => $totalFemale];

    }

}

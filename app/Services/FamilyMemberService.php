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

        if(($sector = $request->query('sector')) && ($locality = $request->query('locality'))) {
            $report = 
            Cache::remember('familyMembersCountReport_sector_' .$sector.'_locality_'.$locality , now()->addMinutes(1), function () use ($sector, $locality) {
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
            $report = Cache::remember('familyMembersCountReport', now()->addMinutes(1), function() {
                return FamilyMember::selectRaw('relation, count(id) as count')->groupBy('relation')->get();
            });
        }
        
        $report = $report->groupBy('relation');


        $totalCount = Cache::remember('count_of_members_cache', now()->addMinutes(1), function() {
            return FamilyMember::count();
        });

        return ['report' => $report, 'totalCount' => $totalCount];
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

        $report = $query->latest('families.created_at')->get()->groupBy('family_size'); 

        $moreTenMembersQuery = $moreTenMembersQuery->get();

        $moreTenMembersCount = 0;

        foreach ($moreTenMembersQuery as $value) {
            $moreTenMembersCount++;
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

        $query = DB::table('family_members')
                ->join('families', 'family_members.family_id', 'families.id')
                ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                ->selectRaw('family_members.gender')
                ->where('family_members.age', '<=', 18)->where('family_members.relation',  "ابن")->orWhere('family_members.relation',  "ابنة")
                ->groupBy(['family_members.gender']);

        if ($request->query('age') == 'all' || is_null($request->query('age'))) {
            $query->selectRaw('COUNT(family_members.age) as count')->groupBy(['family_members.gender']);
        }

        if ($request->query('gender') == 'all' || is_null($request->query('gender'))) {
            $query->where('family_members.gender', $request->query('gender'))->groupBy(['family_members.gender']);
        }

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector')->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector', 'family_members.gender']);
        }

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->selectRaw('addresses.locality')->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'family_members.gender']);
        }

        if ($request->query('age') != 'all' && $request->query('age') == 'under5') {
            $query->selectRaw('COUNT(CASE WHEN family_members.age <= 5 THEN 1 END) AS count')->groupBy(['family_members.gender', 'family_members.gender']);
        }

        if ($request->query('age') != 'all' && $request->query('age') == 'from6To12') {
            $query->selectRaw('COUNT(CASE WHEN family_members.age BETWEEN 6 AND 12 THEN 1 END) AS count')->groupBy(['family_members.gender']);
        }

        if ($request->query('age') != 'all' && $request->query('age') == 'from13To16') {
            $query->selectRaw('COUNT(CASE WHEN family_members.age BETWEEN 13 AND 16 THEN 1 END) AS count')->groupBy(['family_members.gender']);
        }

        if ($request->query('age') != 'all' && $request->query('age') == 'from17To18') {
            $query->selectRaw('COUNT(CASE WHEN family_members.age BETWEEN 17 AND 18 THEN 1 END) AS count')->groupBy(['family_members.gender']);
        }

     

        $report = $query->get()->groupBy('gender');
        // dd($report);
        $totalMale = @($report->get('ذكر') == null ? 0 : $report->get('ذكر')->sum('count'));
        $totalFemale = @($report->get('أنثى') == null ? 0 : $report->get('أنثى')->sum('count'));
        // dd($report->get('أنثى'));
        // dd($totalFemale);

        return ['report' => $report, 'totalMale' => $totalMale, 'totalFemale' => $totalFemale];

    }

}

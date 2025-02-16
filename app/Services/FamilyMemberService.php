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

        if(($sector = $request->query('sector') && $request->query('sector') != 'all') && ($locality = $request->query('locality') && $request->query('locality') != 'all')) {
           
            if (!is_null($request->query('month')) && $request->query('month') != '')  {


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
                                COUNT(CASE WHEN f.gender = "أنثى" AND f.relation = "زوجة" THEN 1 END) AS "countOfWidow",
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

                            AND

                                MONTH(f.created_at) as month

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


            $totalCountOfMembers =  (@$report->get('ذكر')[0]->countOfMales  ?? 0) + (@$report->get('أنثى')[0]->countOfFemales ?? 0) + ($countOfWidow);


            return ['report' => $report,  'countOfWidow' => $countOfWidow ,  'totalCountOfMembers' => $totalCountOfMembers];




                
            }


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


            $totalCountOfMembers =  (@$report->get('ذكر')[0]->countOfMales  ?? 0) + (@$report->get('أنثى')[0]->countOfFemales ?? 0) + ($countOfWidow);


            return ['report' => $report,  'countOfWidow' => $countOfWidow ,  'totalCountOfMembers' => $totalCountOfMembers];















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

        return ['report' => $report,  'countOfWidow' => $countOfWidow ,  'totalCountOfMembers' => $totalCountOfMembers];

    }

}

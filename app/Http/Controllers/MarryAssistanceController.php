<?php

namespace App\Http\Controllers;


use Exception;
use App\Http\Requests\MarryAssistanceRquest;
use App\Models\MarryAssistance;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\DB;

class MarryAssistanceController extends Controller
{

    public function create($member)
    {
        return view('marryAssistances.create', ['member' => FamilyMember::findOrFail($member)]);
    }

    public function store(MarryAssistanceRquest $request, int $member)
    {
        $data = $request->validated();

        try {
            $member = FamilyMember::findOrFail($member);
            $member->marryAssistances()->create($data);
            return back()->with('success', 'تم اضافة الخدمة بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        return view('marryAssistances.edit', ['marryAssistance' => MarryAssistance::findOrFail($id)->loadMissing('familyMember')]);
    }


    public function update(MarryAssistanceRquest $request, $id)
    {
        $data = $request->validated();

        try {
            MarryAssistance::findOrFail($id)->update($data);
            return back()->with('success', 'تم تعديل الخدمة بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }   

    public function report()
    {
        $request = request();

        $report = null;

        if(($sector = $request->query('sector')) && ($locality = $request->query('locality'))) {
            $report = collect(DB::select('
                                SELECT 
                                    m.relation,
                                    ma.status,
                                    SUM(ma.budget) as budget,
                                    SUM(ma.budget_from_org) as budget_from_org,
                                    SUM(ma.budget_out_of_org) as budget_out_of_org,
                                    COUNT(m.id) as count,
                                    a.sector,
                                    a.locality 
                                FROM
                                    marry_assistances ma
                                INNER JOIN
                                    family_members m
                                ON 
                                    m.id = ma.family_member_id
                                INNER JOIN
                                    addresses  a
                                ON
                                    a.family_id = m.family_id 
                                WHERE 
                                    a.sector = ?
                                AND 
                                    a.locality = ?
                                GROUP BY
                                    m.relation, a.sector, a.locality, ma.status
                        ', [$sector, $locality]
                ));
        } else {
            //Cache::forget('marrys_report');
            $report = collect(DB::select('
                                SELECT 
                                    m.relation,
                                    ma.status,
                                    SUM(ma.budget) as budget,
                                    SUM(ma.budget_from_org) as budget_from_org,
                                    SUM(ma.budget_out_of_org) as budget_out_of_org,
                                    COUNT(m.id) as count
                                FROM
                                    marry_assistances ma
                                INNER JOIN
                                    family_members m
                                ON 
                                    m.id = ma.family_member_id
                                GROUP BY
                                    ma.status, m.relation
                    '
                ));
            
            //Cache::remember('marrys_report', now()->addMinutes(10), function() {
              //  return 
            //});
        }
        
        $report = $report->groupBy(['relation', 'status']);

        //dd($report);
        return view('reports.marriesAssistancesReport', compact('report'));
    }



    public function delete($id)
    {
        return view('marryAssistances.delete', ['marryAssistance' => MarryAssistance::findOrFail($id)]);
    }

    public function destroy($id)
    {
        try {
            $marry = MarryAssistance::findOrFail($id);
            $memberId = $marry->familyMember->id;
            $marry->delete();
            return to_route('familyMembers.show', $memberId)->with('success', 'تم حذف خدمة الزواج بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


}

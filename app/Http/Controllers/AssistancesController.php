<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Http\Request;
use App\Models\Family;
use App\Models\Assistance;
use Illuminate\Support\Facades\DB;

class AssistancesController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $family)
    {
        return view('assistances.create', ['family' => Family::findOrFail($family)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id)
    {
        $data = $request->validate([
            'type'                => 'required',
            'status'              => 'required|in:مطلوب,منفذ',
            'budget'              => 'required|numeric',
            'budget_from_org'     => 'numeric|nullable',
            'budget_out_of_org'   => 'numeric|nullable',
            'notes'               => 'nullable|string'
        ], [
            'budget'    => 'المبلغ مطلوب'
        ]);

        try {
            Family::findOrFail($id)->assistances()->create($data);
            return back()->with('success', 'تم اضافة المساعدة بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($family, $id)
    {
        return view('assistances.edit', [
            'family'     => Family::findOrFail($family),
            'assistant'  => Assistance::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $family, $id)
    {
        $data = $request->validate([
            'type'                => 'required',
            'status'              => 'required|in:مطلوب,منفذ',
            'budget'              => 'required|numeric',
            'budget_from_org'     => 'numeric|nullable',
            'budget_out_of_org'   => 'numeric|nullable',
            'notes'               => 'nullable|string'
        ], [
            'budget'    => 'المبلغ مطلوب'
        ]);

        try {
            Assistance::findOrFail($id)->update($data);
            return back()->with('success', 'تم تعديل المساعدة بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id) 
    {
        return view('assistances.delete', ['assistance' => Assistance::findOrFail($id)]);
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
            $ass = Assistance::findOrFail($id);
            $family = $ass->family->id;
            $ass->delete();

            return to_route('families.socialServices', $family)->with('success', 'تم حذف المساعدة بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getReport() {

        $request = request();

        $report = [];

        if(($sector = $request->query('sector')) && ($locality = $request->query('locality'))) {
            $report =
                 collect(DB::select('
                            SELECT 
                                s.type, 
                                s.status,
                                COUNT(s.type) as count,
                                SUM(s.budget) AS budget,
                                SUM(s.budget_from_org) AS budget_from_org,
                                SUM(s.budget_out_of_org) AS budget_out_of_org,
                                a.sector,
                                a.locality
                            FROM
                                assistances s
                            INNER JOIN
                                addresses  a
                            ON
                                a.family_id = s.family_id 
                            WHERE 
                                a.sector = ?
                            AND 
                                a.locality = ?
                            GROUP BY
                                s.type, a.sector, a.locality, s.status
                    ', [$sector, $locality]
            ));

           
        } else {
            $report = 
                 Assistance::selectRaw('type, status, count(id) as count, SUM(budget) as budget, SUM(budget_from_org) as budget_from_org, SUM(budget_out_of_org) as budget_out_of_org')->groupBy(['status', 'type'])->get();     
           
        }

        $report = $report->groupBy(['status', 'type']);

        //dd($report->get('مطلوب'));

        return view('reports.assistancesReport', compact('report'));
    }

}

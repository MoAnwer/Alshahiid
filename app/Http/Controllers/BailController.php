<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\BailRequest;
use App\Models\Bail;
use App\Models\Family;
use Illuminate\Support\Facades\DB;

class BailController extends Controller
{

    protected $returnToRoute = 'families.show';

    public function index()
    {
        //
    }

    public function create(int $family)
    {
        return view('bails.create', ['family' => Family::findOrFail($family)]);
    }

    public function store(BailRequest $request, int $family)
    {
        $data = $request->validated();

        try {
            $family = Family::findOrFail($family);
            $family->bails()->create($data);
            return back()->with('success', 'تم اضافة بيانات الكفالة بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return view('bails.edit', ['bail' => Bail::findOrFail($id)]);
    }

    public function update(BailRequest $request, $id)
    {
        $data = $request->validated();

        try {
            Bail::findOrFail($id)->update($data);
            return back()->with('success', 'تم تعديل بيانات الكفالة بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function delete($id) 
    {
        return view('bails.delelte', ['bail' => Bail::findOrFail($id)]);
    }

    public function destroy($id)
    {
        $bail     = Bail::findOrFail($id);
        $familyId = $bail->family_id;
        $bail->delete();
        return to_route($this->returnToRoute, $familyId)->with('success', 'تم حذف بيانات الكفالة بنجاح');
    }

    public function report() 
    {

         if(($sector = request()->query('sector')) && ($locality = request()->query('locality'))) {
            $report = collect(DB::select('
                            SELECT 
                               b.type, b.status, count(b.type) as count, SUM(b.budget) as budget, SUM(b.budget_from_org) as budget_from_org, SUM(b.budget_out_of_org) as budget_out_of_org,
                                addresses.sector,
                                addresses.locality
                            FROM 
                                bails b
                            INNER JOIN 
                                addresses
                            ON 
                                addresses.family_id = b.family_id
                            WHERE
                                addresses.sector = ?
                            AND 
                                addresses.locality = ? 
                            GROUP BY
                                b.type, b.status, addresses.sector, addresses.locality
                            '
                , 
                [$sector, $locality]
            ));
            $report = $report->groupBy(['type', 'status']);


            return view('reports.bails', compact('report'));

        }

                $report = DB::table('bails')
                ->selectRaw('type, status, count(type) as count, SUM(budget) as budget, SUM(budget_from_org) as budget_from_org, SUM(budget_out_of_org) as budget_out_of_org')->groupBy(['type', 'status'])->get();
        $report = $report->groupBy(['type', 'status']);

        //dd($report);

        return view('reports.bails', compact('report'));
    }

}

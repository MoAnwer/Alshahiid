<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Family;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{


    public function create(int $family) 
    {
        return view('address.create', 
            ['family' => Family::findOrFail($family)]
        );
    }
    

    public function store(Request $request, int $family) 
    {
        $data = $request->validate([
            'sector'       => 'required',
            'locality'     => 'required',
            'type'         => 'required',
            'neighborhood' => 'string|required'
        ], [
            'neighborhood' => 'اسم الحي مطلوب'
        ]);

        try {

            $family = Family::findOrFail($family);
            $family->addresses()->create($data);

            return back()->with('success', 'تم انشاء السكن بنجاح');

        } catch(Exception $e) {

            return $e->getMessage();

        } 
    }

    public function edit(int $id) 
    {
		try {
			$address = Address::findOrFail($id);
			return view('address.edit', compact('address'));	
		} catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, int $id) 
    {

        $data = $request->validate([
            'sector'       => 'required',
            'locality'     => 'required',
            'type'         => 'required',
            'neighborhood' => 'string|required'
        ], [
            'neighborhood' => 'اسم الحي مطلوب'
        ]);
		
        try {

            $address = Address::findOrFail($id);
            $address->update($data);

            return back()->with('success', 'تم تعديل بيانات السكن بنجاح');

        } catch(Exception $e) {

            return $e->getMessage();

        }
        
    } 

    public function delete(int $id) 
    {
        try {
            return view('address.delete', ['address' => Address::findOrFail($id)]);
        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function destroy(int $id)  
    {
        try {

            $address  = Address::findOrFail($id);
            $familyId = $address->family->id;
            $address->delete();

            return to_route('families.show', $familyId)->with('success', 'تم حذف بيانات السكن بنجاح');

        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function report()
    {
        $report =  
                DB::table('addresses')
                            ->selectRaw('type, COUNT(id) as count')
                            ->groupBy('type')
                            ->get();   


        $report = $report->groupBy('type');
        
        $homeServicesReport = 
                DB::table('home_services')
                        ->selectRaw('
                                    SUM(budget) as totalBudget,
                                    status, 
                                    COUNT(status) as count, 
                                    type,
                                    SUM(budget_from_org)  as budget_from_org,
                                    SUM(budget_out_of_org) as budget_out_of_org
                                    ')
                                    ->groupBy(['type', 'status'])->get();

        $homeServicesReport = collect([
            'build' => [
                'need'   => $homeServicesReport->get(0), 
                'done'   => $homeServicesReport->get(1)
            ],
            'complete_build'   => [
                'need'   => $homeServicesReport->get(2), 
                'done'   => $homeServicesReport->get(3)
            ]
        ]);

        $homeServicesReport->prepend([
            'build' => round(
                ( ($homeServicesReport->get('build')['done']->count ?? 0) / ($homeServicesReport->get('build')['need']->count ?? 1) ) * 100
                , 1),

            'complete_build'   => round(
                ( ($homeServicesReport->get('complete_build')['done']->count ?? 0)  / ($homeServicesReport->get('complete_build')['need']->count ?? 1) ) * 100
                , 1),
            'total'  => round(
                (
                    (($homeServicesReport->get('build')['done']->count ?? 0)   + ( $homeServicesReport->get('complete_build')['done']->count ?? 1) )
                    / 
                    (($homeServicesReport->get('build')['need']->count ?? 0) +  ($homeServicesReport->get('complete_build')['need']->count ?? 1) ) 
                ) * 100
                  
            , 1)
        ], 'precentages');

        $homeServicesReport->prepend([
            'total_budget'               => 
                      ( ($homeServicesReport->get('build')['need']->totalBudget ?? 0 )  +  ($homeServicesReport->get('build')['done']->totalBudget ?? 0) )
                    + ( ($homeServicesReport->get('complete_build')['need']->totalBudget ?? 0)  +  ($homeServicesReport->get('complete_build')['done']->totalBudget ?? 0) )

            ,
            'total_budget_from_org'      =>         
                      (($homeServicesReport->get('build')['need']->budget_from_org) ?? 0 + ( $homeServicesReport->get('build')['done']->budget_from_org?? 0))
                    + (($homeServicesReport->get('complete_build')['need']->budget_from_org ?? 0) +  ($homeServicesReport->get('complete_build')['done']->budget_from_org?? 0))
            ,

            'total_budget_out_of_org'    => 
                      (($homeServicesReport->get('build')['done']->budget_out_of_org ?? 0) + ($homeServicesReport->get('build')['need']->budget_out_of_org?? 0) )
                    + (($homeServicesReport->get('complete_build')['done']->budget_out_of_org) ?? 0 + ($homeServicesReport->get('complete_build')['need']->budget_out_of_org ?? 0))
            ,
            'total_money'                =>
                      (($homeServicesReport->get('build')['need']->budget_from_org ?? 0) +  ($homeServicesReport->get('build')['done']->budget_from_org?? 0))
                    + (($homeServicesReport->get('complete_build')['need']->budget_from_org ?? 0) +  ($homeServicesReport->get('complete_build')['done']->budget_from_org?? 0))
                    + (($homeServicesReport->get('build')['done']->budget_out_of_org ?? 0) + ($homeServicesReport->get('build')['need']->budget_out_of_org?? 0))
                    + (($homeServicesReport->get('complete_build')['done']->budget_out_of_org ?? 0)+ ($homeServicesReport->get('complete_build')['need']->budget_out_of_org?? 0))

        ], 'totals');

        return view('reports.address', compact('report', 'homeServicesReport'));
    }
}

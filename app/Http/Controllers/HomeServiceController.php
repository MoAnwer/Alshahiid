<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Family;
use App\Models\HomeService;
use Illuminate\Support\Facades\DB;

class HomeServiceController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $family)
    {
		try {
			$family = Family::findOrFail($family);
		
			return view('homesServices.create', compact('family'));
			
		} catch(Exception $e) {
			return $e->getMessage();
		}

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $family)
    {
		//dd($request->manager_name);
		
		$data = $request->validate([
            'type'      		=> "required|in:تشييد,اكمال التشييد",
            'status'            => 'required|in:مطلوب,منفذ',
            'budget'            => 'numeric|required',
            'budget_from_org'   => 'nullable|numeric',
            'budget_out_of_org' => 'nullable|numeric',           
            'manager_name'      => 'string|required',
            'notes'             => 'nullable|string',
        ], [
			'manager_name' => 'اسم المدير اجباري',
			'budget'       => 'حقل التقديري اجباري'
		]);
		
		
		try {
				
			$family = Family::find($family);
			
			$family->homeService()->create($data);
            
            
			return back()->with('success', 'تم اضافة مشروع سكن جديد بنجاح');
			
		} catch(Exception $e) {
			
			return $e->getMessage();
		}
		
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $home)
    {
		
		try {
			$home = HomeService::findOrFail($home);
			return view('homesServices.edit', compact('home'));
			
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $family, $home)
    {
		$data = $request->validate([
            'type'      		=> "required|in:تشييد,اكمال التشييد",
            'status'            => 'required|in:مطلوب,منفذ',
            'budget'            => 'numeric|required',
            'budget_from_org'   => 'nullable|numeric',
            'budget_out_of_org' => 'nullable|numeric',           
            'manager_name'      => 'string|required',
            'notes'             => 'nullable|string',
        ], [
			'manager_name' => 'اسم المدير اجباري',
			'budget'       => 'حقل التقديري اجباري'
		]);
		
		//dd($data);

		try {
	
			$family = Family::findOrFail($family);
			
			$home = $family->homeServices()->find($home)->update($data);
			
			// $home->update($data);

            
			
			return back()->with('success', "تم التعديل بنجاح");
			
		} catch (Exception $e) {
			
			return $e->getMessage();
		}
    }


	 public function delete($id) {
        try {

            $home = HomeService::findOrFail($id);
			
            return view('homesServices.delete', compact('home'));

        } catch (Exception $e) {
			
            return $e->getMessage();
        }

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

            $home = HomeService::findOrFail($id);

            $familyId = $home->family->id;

            $home->delete();

            
            
            return to_route('families.socialServices', $familyId)->with('success', 'تم حذف المشروع بنجاح ');

        } catch(Exception $e) {

            return $e->getMessage();

        }
    }

    public function report() 
    {
        
       $request = request();

       $query = DB::table('home_services')
                ->join('families', 'families.id', 'home_services.family_id')
                ->join('martyrs','martyrs.id', 'families.martyr_id')
                ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                ->selectRaw('
                    SUM(home_services.budget) as totalBudget,
                    home_services.status as status, 
                    COUNT(home_services.status) as count, 
                    home_services.type as type,
                    SUM(home_services.budget_from_org)  as budget_from_org,
                    SUM(home_services.budget_out_of_org) as budget_out_of_org,
                    SUM(home_services.budget_out_of_org + home_services.budget_from_org) AS totalMoney
                ', 
                )->groupBy(['home_services.type', 'home_services.status']);

        if (!empty($request->query('type')) && $request->query('type') != 'all') {
            $query->where('home_services.type', $request->query('type'))->groupBy(['home_services.type', 'home_services.status']);
        } 


        if (!empty($request->query('category')) && $request->query('category') != 'all') {
            $query->selectRaw('families.category as category')->where('families.category', $request->query('category'))
            ->groupBy(['families.category', 'home_services.type', 'home_services.status']);
        } 
        
        if (!empty($request->query('force')) && $request->query('force') != 'all') {
            $query->selectRaw('martyrs.force')->where('martyrs.force', $request->query('force'))->groupBy(['martyrs.force', 'home_services.type', 'home_services.status']);
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector', 'home_services.type', 'home_services.status']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            
            $query->selectRaw('addresses.locality as locality')->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'home_services.type', 'home_services.status']);

        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(home_services.created_at) as month')->whereMonth('home_services.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(home_services.created_at) as year')->whereYear('home_services.created_at',  $request->query('year'))->groupBy('year');
        } 

        $homeServicesReport = $query->latest('home_services.created_at')->get()->groupBy(['type', 'status']); 
        // dd($homeServicesReport);

        return view('reports.homeServices', compact('homeServicesReport'));
    }
}

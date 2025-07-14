<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\InjuredService;
use App\Models\Injured;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InjuredServiceController extends Controller
{

    public function create($injured)
    {
		$injured = Injured::findOrFail($injured);
		
        return view('InjuredServices.create', compact('injured'));
    }


    public function store(Request $request, int $injured)
    {
        $data = $request->validate([
			'name'		  	 =>  'required|string',
			'type'		 	 =>  'required|in:إعانة عامة,سكن,مشروع إنتاجي,طرف صناعي,وسيلة حركة,علاج,تأهيل مهني و معنوي',
			'status'	 	 => 'required|in:مطلوب,منفذ',
			'description' 	 => 'nullable|string',
			'budget'	 	 => 'numeric|required',
			'budget_from_org' => 'numeric|nullable',
			'budget_out_of_org'	  => 'numeric|nullable',
			'notes'	  => 'string|nullable'
		], [
			'name'			=> 'حقل الاسم مطلوب',
			'budget'		=> 'حقل المبلغ مطلوب'
		]);
		
		try {

			$injured = Injured::find($injured);
			$injured->InjuredServices()->create($data);
			return back()->with('success', 'تم اضافة الخدمة بنجاح 👍🏼✅');
		} catch (Exception $e)  {
			return abort(404, ['errorMsg' => $e->getMessage()]);
		}
    }


    public function edit($id)
    {
		return view('injuredServices.edit', ['injuredService' => InjuredService::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
				'name'		  	 	=>  'required|string',
				'type'		 		=>  'required|in:إعانة عامة,سكن,مشروع إنتاجي,طرف صناعي,وسيلة حركة,علاج,تأهيل مهني و معنوي',
				'status'	 	 	=> 'required|in:مطلوب,منفذ',
				'description' 	 	=> 'nullable|string',
				'budget'	 	 	=> 'numeric|required',
				'budget_from_org' 	=> 'numeric|nullable',
				'budget_out_of_org'	  => 'numeric|nullable',
				'notes'	  			=> 'string|nullable'
			], [
				'name'		=> 'حقل الاسم مطلوب',
				'budget'	=> 'حقل المبلغ مطلوب'
			]);
		
		try {
			$service = InjuredService::findOrFail($id);
			$service->update($data);
			
			return back()->with('success', 'تم التعديل على الخدمة بنجاح 👍🏼✅');
		} catch (Exception $e)  {
			return abort(404, ['errorMsg' => $e->getMessage()]);
		}
    }

	public function delete($id)
    {
       return view('injuredServices.delete', ['injuredService' => InjuredService::findOrFail($id)]);
    }

    public function destroy($id)
    {
        $injuredService = InjuredService::findOrFail($id);
        $injuredId		= $injuredService->injured->id;
        $injuredService->delete();
		
		return to_route('injureds.show', $injuredId)->with('success', 'تم حذف الخدمة بنجاح 👍🏼✅');
		
    }

	public function report()
	{


		// $report  = InjuredService::selectRaw('type, status, count(*) as count, SUM(budget) as budget, SUM(budget_from_org) as budget_from_org, SUM(budget_out_of_org) as budget_out_of_org')->groupBy(['type', 'status'])->get();

		// $report = $report->groupBy(['type', 'status']);


        $request = request();

        $query = DB::table('injured_services')
                ->leftJoin('injureds', 'injureds.id', 'injured_services.injured_id')
                ->selectRaw('
                    injured_services.status as status,
                    injured_services.type as type,
                    SUM(injured_services.budget) as  budget,  
                    SUM(injured_services.budget_from_org) as budget_from_org,
                    SUM(injured_services.budget_out_of_org)  as budget_out_of_org,                   
                    SUM(injured_services.budget_out_of_org + injured_services.budget_from_org)  as totalMoney,
                    COUNT(injured_services.status) as count
                ', 
                )->groupBy(['injured_services.status', 'injured_services.type']);


        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('injureds.sector as sector')->where('injureds.sector', $request->query('sector'))
            ->groupBy(['injureds.sector', 'injured_services.status', 'injured_services.type']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->selectRaw('injureds.locality as locality')->where('injureds.locality', $request->query('locality'))
            ->groupBy(['injureds.sector', 'injureds.locality', 'injured_services.status', 'injured_services.type']);
        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(injured_services.created_at) as month')->whereMonth('injured_services.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(injured_services.created_at) as year')->whereYear('injured_services.created_at',  $request->query('year'))->groupBy('year');
        } 

        $report = $query->get()->groupBy(['type', 'status']); 

		// dd($report);

		return view('reports.injuredServices', compact('report'));
	}
}

<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\InjuredService;
use App\Models\Injured;
use Illuminate\Http\Request;

class InjuredServiceController extends Controller
{

    public function index()
    {
        //
    }

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
			InjuredService::find($id)->update($data);
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

			$report  = InjuredService::selectRaw('type, status, count(*) as count, SUM(budget) as budget, SUM(budget_from_org) as budget_from_org, SUM(budget_out_of_org) as budget_out_of_org')->groupBy(['type', 'status'])->get();

			$report = $report->groupBy(['type', 'status']);

			//dd($report);

			return view('reports.injuredServices', compact('report'));
		}
}

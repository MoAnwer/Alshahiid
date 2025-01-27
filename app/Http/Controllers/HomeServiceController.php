<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Family;
use App\Models\HomeService;

class HomeServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
			return abort(404);
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
			
			return abort(404);
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
    public function edit(int $home)
    {
		
		try {
			$home = HomeService::findOrFail($home);
			return view('homesServices.edit', compact('home'));
			
        } catch (Exception $e) {
            return abort(404);
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
			
			return abort(404);
		}
    }


	 public function delete($id) {
        try {

            $home = HomeService::findOrFail($id);
			
            return view('homesServices.delete', compact('home'));

        } catch (Exception $e) {
			
            return abort(404);
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
            
            return to_route('families.show', $familyId)->with('success', 'تم حذف المشروع بنجاح ');

        } catch(Exception $e) {

            return abort(404);

        }
    }
}

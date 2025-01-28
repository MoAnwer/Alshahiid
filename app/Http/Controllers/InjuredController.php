<?php

namespace App\Http\Controllers;

use Exception;
use PDOException;
use Illuminate\Http\Request;
use App\Models\Injured;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;


class InjuredController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		    $injureds = Cache::remember('injureds_page_'. request('page', 1), now()->addMinutes(10), function() {
          return Injured::orderByDESC('id')->paginate();
        });
		
        return view('injureds.index', compact('injureds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('injureds.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $data = $request->validate([
          'name'		   		 => 'required|string',
          'type'		   		 => 'required|string',
          'injured_date' 	     => 'required|date',
          'injured_percentage' => 'required|numeric',
          'notes'		  		 => 'nullable|string',
          'health_insurance_number' => 'nullable|unique:injureds,health_insurance_number',
          'health_insurance_start_date' => 'nullable',
          'health_insurance_end_date' => 'nullable'
      ], [
          'name'		   		 => 'اسم المصاب مطلوب',
          'type'		   		 => 'نوع الاصابة مطلوب',
          'injured_percentage' => 'نسبة الاصابة ضرورية',
          'injured_date' 		 => 'تاريخ الاصابة مطلوب',
          'health_insurance_number.unique' => 'رقم التأمين موجود بالفعل'
      ]);
		
		try {
			  Injured::create($data);
			  return back()->with('success', 'تم اضافة بيانات المصاب بنجاح   ✅👍🏼');
		  } catch (PDOException $e) {
  			return $e->getMessage();
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
		return view('injureds.show', ['injured' =>  Cache::remember('injured_show', '10', fn() => Injured::findOrFail($id)) ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$injured = Injured::findOrFail($id);
		return view('injureds.edit', compact('injured'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      $data = [];


      if (isset($request->health_insurance_number)) {
        $data = $request->validate([
              'name'                 => 'required|string',
              'type'                 => 'nullable|string',
              'injured_date'         => 'required|date',
              'injured_percentage' => 'required|numeric',
              'notes'                => 'nullable|string',
              'health_insurance_number' => 'nullable|unique:injureds,health_insurance_number',
              'health_insurance_start_date' => 'nullable',
              'health_insurance_end_date' => 'nullable'

          ], [
            'name'               => 'اسم المصاب مطلوب',
            'type'               => 'نوع الاصابة مطلوب',
            'injured_percentage' => 'نسبة الاصابة ضرورية',
            'injured_date'       => 'تاريخ الاصابة مطلوب',
            'health_insurance_number.unique' => 'رقم التأمين موجود بالفعل'
        ]);
      } else {
          $data = $request->validate([
              'name'                 => 'required|string',
              'type'                 => 'nullable|string',
              'injured_date'         => 'required|date',
              'injured_percentage' => 'required|numeric',
              'notes'                => 'nullable|string',
              'health_insurance_start_date' => 'nullable',
              'health_insurance_end_date' => 'nullable'

          ], [
            'name'               => 'اسم المصاب مطلوب',
            'type'               => 'نوع الاصابة مطلوب',
            'injured_percentage' => 'نسبة الاصابة ضرورية',
            'injured_date'       => 'تاريخ الاصابة مطلوب',
        ]);
      }

		
		  Injured::findOrFail($id)->update($data);
		  return back()->with('success', 'تم التعديل بنجاح   ✅👍🏼');
    }

	public function delete($id)
    {
        return view('injureds.delete', ['injured' => Injured::findOrFail($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        injured::findOrFail($id)->delete();
		return to_route('injureds.index')->with('success', 'تم حذف بيانات المصاب بنجاح');
    }

  public function report() 
  {

    $between80And89 = DB::table('injureds')->whereBetween('injured_percentage', [80, 89])->count();
    $between90And100 = DB::table('injureds')->whereBetween('injured_percentage', [90, 100])->count();
    $report = collect([
        '80-89'     => $between80And89,
        '90-100'    => $between90And100,
        'total'     => $between80And89 + $between90And100
    ]);

    return view('reports.injureds', compact('report'));
  }

  public function injuredsTamiin()
  {
    $hasTamiin = DB::table('injureds')->where('health_insurance_number', '<>', null)->where('health_insurance_end_date', '<', now())->count();
    $hasNoTamiin = DB::table('injureds')->where('health_insurance_number', '=', null)->count();
    
    $report = collect([
        'has'     => $hasTamiin,
        'no'    => $hasNoTamiin,
        'total'     => $hasTamiin + $hasNoTamiin
    ]);

    return view('reports.injuredsTamiin', compact('report'));

  }
}

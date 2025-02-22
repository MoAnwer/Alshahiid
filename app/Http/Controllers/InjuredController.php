<?php

namespace App\Http\Controllers;

use Exception;
use PDOException;
use Illuminate\Http\Request;
use App\Models\Injured;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class InjuredController extends Controller
{
    protected $log;
    protected Injured $injured;


    public function __construct() 
    {
        $this->injured = new Injured;
        $this->log  = Log::stack(['stack' => Log::build(['driver' => 'single', 'path' => storage_path('logs/alshahiid.log')]) ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();

        $needel = trim($request->query('needel'));

        $query = $this->injured::query();

        if($request->query('search') == 'name') {
            $query->where('name', 'LIKE', "%{$needel}%");
        }

        if($request->query('search') == 'national_number') {
            $query->where('national_number', $needel);
        }

        if($request->query('search') == 'phone') {
            $query->where('phone', '=', $needel);
        }


        if($request->query('search') == 'health_insurance_number') {
            $query->where('health_insurance_number', $needel);
        }

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
          $query->where('sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
          $query->where('locality', $request->query('locality'));
        } 

		    $injureds = $query->orderByDESC('id')->paginate(10);		
        
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
          'phone'           => 'required|string|unique:injureds,phone',
          'injured_date' 	     => 'required|date',
          'injured_percentage' => 'required|numeric',
          "national_number" => "required|numeric|unique:injureds,national_number",
          'notes'		  		 => 'nullable|string',
          'health_insurance_number' => 'nullable|unique:injureds,health_insurance_number',
          'health_insurance_start_date' => 'nullable',
          'health_insurance_end_date' => 'nullable',
          'sector'  => 'required',
          'locality'  => 'required'
      ], [
          'name'		   		 => 'اسم المصاب مطلوب',
          'type'		   		 => 'نوع الاصابة مطلوب',
          'injured_percentage' => 'نسبة الاصابة ضرورية',
          'injured_date' 		 => 'تاريخ الاصابة مطلوب',
          'health_insurance_number.unique' => 'رقم التأمين موجود بالفعل',
          'national_number.required'   => 'الرقم الوطني اجباري',
          'phone.unique'   => 'رقم الهاتف موجود بالفعل',
          'national_number.unique'   => 'الرقم الوطني موجود بالفعل',
          'phone' => "رقم الهاتف مطلوب"
      ]);
		
		  try {
			  $this->injured->create($data);

        

			  return back()->with('success', 'تم اضافة بيانات المصاب بنجاح   ✅👍🏼');

		  } catch (PDOException $e) {

        $this->log->error('store injured', ['exception' => $e->getMessage()]);
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
		  return view('injureds.show', ['injured' => $this->injured->findOrFail($id)->loadMissing('injuredServices')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $injured = $this->injured->findOrFail($id);
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

      $roles = [
        'name'                 => 'required|string',
        'type'                 => 'nullable|string',
        'injured_date'         => 'required|date',
        'injured_percentage' => 'required|numeric',
        'notes'                => 'nullable|string',
        'health_insurance_start_date' => 'nullable|date',
        'health_insurance_end_date' => 'nullable|date',          
        'sector'  => 'required',
        'locality'  => 'required'
      ];

      $messages = [
        'name'               => 'اسم المصاب مطلوب',
        'type'               => 'نوع الاصابة مطلوب',
        'injured_percentage' => 'نسبة الاصابة ضرورية',
        'injured_date'       => 'تاريخ الاصابة مطلوب',
      ];

      
      if (isset($request->health_insurance_number)) {
        $roles['health_insurance_number']         =  'nullable|unique:injureds,health_insurance_number';
        $messages['health_insurance_number.unique']  =  'رقم التأمين موجود بالفعل';
      } 
      
    
      
      if (isset($request->national_number)) {
        $roles['national_number']            =  'required|numeric|unique:injureds,national_number';
        $messages['national_number.unique']  =   'الرقم الوطني موجود بالفعل';
      } 
      
    
      
      if (isset($request->phone)) {
        $roles['phone']            =  'required|numeric|unique:injureds,phone';
        $messages['phone.unique']  =  "رقم الهاتف موجود بالفعل";
      } 
      
      $data = $request->validate($roles, $messages);

		
    try {

      $this->injured->findOrFail($id)->update($data);      

      return back()->with('success', 'تم التعديل بنجاح   ✅👍🏼');

    } catch (Exception $e) {

      $this->log->error('update injured id='.$id, ['exception' => $e->getMessage()]);

      return $e->getMessage();
    }

    }
    

    public function delete($id)
    {
      return view('injureds.delete', ['injured' => $this->injured->findOrFail($id)]);
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

          $this->injured->findOrFail($id)->delete();

        

          

          return to_route('injureds.index')->with('success', 'تم حذف بيانات المصاب بنجاح');

      } catch (Exception $e) {
        $this->log->error('destroy injured', ['exception' => $e->getMessage()]);
        return $e->getMessage();

      }

    }


  public function report() 
  {

    // 

    $request = request();

    $between80And89  = DB::table('injureds')->whereBetween('injured_percentage', [80, 89]);
    $between90And100 = DB::table('injureds')->whereBetween('injured_percentage', [90, 100]);


      if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
          $between80And89->selectRaw('sector')->where('sector', $request->query('sector'))
          ->groupBy(['sector']);
           $between90And100->selectRaw('sector')->where('sector', $request->query('sector'))
          ->groupBy(['sector']);
      } 

      if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
          $between80And89->selectRaw('locality')->where('locality', $request->query('locality'))
          ->groupBy(['sector', 'locality']);
           $between90And100->selectRaw('locality')->where('locality', $request->query('locality'))
          ->groupBy(['sector', 'locality']);
      } 


    $report = collect([
        '80-89'     => $between80And89->count(),
        '90-100'    => $between90And100->count(),
        'total'     => $between80And89->count() + $between90And100->count()
    ]);
    
    return view('reports.injureds', compact('report'));
  }




  public function injuredsTamiin()
  {

    $request = request();
                                                                                          // 2030-01-01 < 2025-02-09
    $hasTamiin = DB::table('injureds')->where(function ($q) {
      $q->whereNotNull('health_insurance_number')
        ->whereDate('health_insurance_end_date', '>', now());
    });
    
    $hasNoTamiin = DB::table('injureds')->where(function ($q) {
      $q->whereNull('health_insurance_number')
        ->OrWhereDate('health_insurance_end_date', '<', now());
    });

    if (!empty($request->query('sector')) && $request->query('sector') != 'all') {

        $hasTamiin->selectRaw('sector')->where('sector', $request->query('sector'))
        ->groupBy(['sector']);

         $hasNoTamiin->selectRaw('sector')->where('sector', $request->query('sector'))
        ->groupBy(['sector']);
      } 

    if (!empty($request->query('locality')) && $request->query('locality') != 'all') {

        $hasTamiin->selectRaw('locality')->where('locality', $request->query('locality'))
        ->groupBy(['sector', 'locality']);

         $hasNoTamiin->selectRaw('locality')->where('locality', $request->query('locality'))
        ->groupBy(['sector', 'locality']);
    } 

    $report = collect([
        'has'       => $hasTamiin->count(),
        'no'        => $hasNoTamiin->count(),
        'total'     => $hasTamiin->count() + $hasNoTamiin->count()
    ]);

    // dd($report);

    return view('reports.injuredsTamiin', compact('report'));

  }
}

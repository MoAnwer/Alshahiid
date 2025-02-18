<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Communicate;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MartyrCommunicateController extends Controller
{
    protected Family $family;
    protected Communicate $com;

    public function __construct()
    {
        $this->family = new Family;
        $this->com = new Communicate;
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

        $query = DB::table('communicates')
                ->join('families', 'communicates.family_id', 'families.id')
                ->join('martyrs', 'families.martyr_id', 'martyrs.id')
                ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                ->select(
                        'families.id as family_id', 
                        'martyrs.name as martyr_name',
                        'martyrs.force',
                        'communicates.id as id',
                        'communicates.phone',
                        'communicates.isCom', 
                        'communicates.status', 
                        'addresses.sector', 'addresses.locality',
                        'communicates.budget',
                        'communicates.budget_from_org',                                        
                        'communicates.budget_out_of_org',
                        'communicates.notes'
                    );

        if($request->query('search') == 'name') {
            $query->where('martyrs.name', 'LIKE', "%$needel%");
        }

        if($request->query('search') == 'militarism_number') {
            $query->where('martyrs.militarism_number', $needel);
        }

        if($request->query('search') == 'phone') {
            $query->where('communicates.phone', $needel);
        }
        
        if($request->query('force') != 'all' &&  !empty($request->query('force'))) {
            $query->where('martyrs.force', $request->query('force'));
        }

        if (!empty($request->query('status')) && $request->query('status') != 'all') {
            $query->where('communicates.status', $request->query('status'));
        }

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        // if (!is_null( request()->query('month')) &&  request()->query('month') != '') {
        //     $query->whereMonth('communicates.created_at',   request()->query('month'))->groupBy('month');
        // } 

        // if (!is_null( request()->query('year')) &&  request()->query('year') != '') {
        //     $query->whereYear('communicates.created_at',   request()->query('year'))->groupBy('year');
        // }


        $coms = $query->latest('martyrs.id')->paginate(10);
        
        return view('tazkiia.communicate.index', compact('coms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $family)
    {
        return view('tazkiia.communicate.create', ['family' => $this->family->findOrFail($family)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $family)
    {
        $data = $request->validate([
            'phone' => 'required|string',
            'budget'    => 'required|numeric',
            'budget_from_org' => 'nullable|numeric',
            'budget_out_of_org' => 'nullable|numeric',
            'status'    => 'required',
            'isCom' => 'required',
            'notes' => 'nullable|string'
        ], [
            'phone' => 'رقم الهاتف مطلوب',
        ]);

        try {
            $family = $this->family->findOrFail($family);
            $family->communicate()->create($data);

            

            return to_route('families.show', $family->id)->with('success', 'تم  اضافة بيانات التواصل مع اسرة الشهيد  ' . $family->martyr->name . ' بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('tazkiia.communicate.edit', ['com' => $this->com->findOrFail($id)->loadMissing('family')]);
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
        $data = $request->validate([
            'phone' => 'required|string',
            'budget'    => 'required|numeric',
            'budget_from_org' => 'nullable|numeric',
            'budget_out_of_org' => 'nullable|numeric',
            'status'    => 'required',
            'isCom' => 'required',
            'notes' => 'nullable|string'
        ], [
            'phone' => 'رقم الهاتف مطلوب',
            'buget' => 'المبلغ مطلوب'
        ]);

        try {
            $com = $this->com->findOrFail($id);
            $com->update($data);

            
            return back()->with('success', 'تم  التعديل  على بيانات التواصل مع اسرة الشهيد بنجاح');
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

    public function delete($id)
    {
        return view('tazkiia.communicate.delete', ['com' => $this->com->findOrFail($id)->loadMissing('family')]);
    }

    public function destroy($id)
    {
        $com = $this->com->findOrFail($id);
        $com->delete($id);
        
        return to_route('tazkiia.communicate.index')->with('success', 'تم حذف بيانات التواصل مع اسرة الشهيد بنجاح');
    }
}

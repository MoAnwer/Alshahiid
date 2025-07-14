<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Http\Request;
use App\Models\{Assistance, Family};
use Illuminate\Support\Facades\DB;

class AssistancesController extends Controller
{
    protected Family $family;
    protected Assistance $assistance;

    public function __construct()
    {
        $this->family = new Family;
        $this->assistance = new Assistance;
    }


    public function index()
    {
        $request = request();

        $needel  = $request->query('needel');

        $query = DB::table('assistances')
            ->leftJoin('families', 'assistances.family_id', '=', 'families.id')
            ->leftJoin('addresses', 'addresses.family_id', '=','families.id')
            ->leftJoin('martyrs', 'martyrs.id', '=', 'families.martyr_id')
            ->select(
                'addresses.sector as sector',
                'addresses.locality as locality',
                'families.martyr_id',
                'families.id',
                'assistances.id as assistance_id',
                'assistances.type as type',
                'assistances.status as status',
                'assistances.budget as budget',
                'assistances.budget_from_org as budget_from_org',
                'assistances.budget_out_of_org as budget_out_of_org',
                'assistances.created_at as created_at',
                'martyrs.name as martyr_name',
                'martyrs.force as force',
                'assistances.family_id as family_id'
            );

        if ($request->query('search') == 'type') {
            $query->where('assistances.type', 'LIKE', "{$needel}%");
        }


        if ($request->query('search') == 'force') {
            $query->where('martyrs.force', $needel);
        }

        if ($request->query('search') == 'martyr_name') {
            $query->where('martyrs.name', $needel);
        }

        if (!empty($request->query('type')) && $request->query('type') != 'all') {
            $query->where('assistances.type', $request->query('type'));
        } 

        if (!empty($request->query('status')) && $request->query('status') != 'all') {
            $query->where('assistances.status', $request->query('status'));
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        if (!empty($request->query('year')) && $request->query('year') != 'all') {
            $query->whereYear('assistances.created_at', $request->query('year'));
        } 

        if (!empty($request->query('month')) && $request->query('month') != 'all') {
            $query->whereMonth('assistances.created_at', $request->query('month'));
        } 

        $assistances = $query->latest('assistances.id')->paginate(10);

        return view('assistances.index', compact('assistances'));
    }

    public function family($family)
    {
        return view('families.socialServices.assistance', [
            'assistances' =>  $this->assistance->where('family_id', $family)->paginate(),
            'family_with_martyr' =>  $this->family->where('id', $family)->select('id', 'martyr_id')->with('martyr:id,name')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $family)
    {
        return view('assistances.create', ['family' => $this->family->findOrFail($family)]);
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
            $this->family->findOrFail($id)->assistances()->create($data);


            return back()->with('success', 'تم اضافة المساعدة بنجاح');
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
    public function edit($family, $id)
    {
        return view('assistances.edit', [
            'family'     => $this->family->findOrFail($family),
            'assistant'  => $this->assistance->findOrFail($id)
        ]);
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
            $ass = $this->assistance->findOrFail($id);
            $ass->update($data);

            return back()->with('success', 'تم تعديل المساعدة بنجاح');

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id) 
    {
        return view('assistances.delete', ['assistance' => $this->assistance->findOrFail($id)]);
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

            $ass = $this->assistance->findOrFail($id);
            $family = $ass->family->id;            
            $ass->delete();

            return to_route('families.socialServices', $family)->with('success', 'تم حذف المساعدة بنجاح');

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getReport() {

        $request = request();

        $query = DB::table('assistances')
                ->join('families', 'assistances.family_id', 'families.id')
                ->join('martyrs', 'families.martyr_id', 'martyrs.id')
                ->leftJoin('addresses', 'addresses.family_id', 'assistances.family_id')
                ->selectRaw('
                    assistances.status as status,
                    assistances.type as type,
                    SUM(assistances.budget) as  budget,  
                    SUM(assistances.budget_from_org) as budget_from_org,
                    SUM(assistances.budget_out_of_org)  as budget_out_of_org,                   
                    SUM(assistances.budget_out_of_org + assistances.budget_from_org)  as totalMoney,
                    COUNT(assistances.status) as count
                ', 
                )->groupBy(['assistances.status', 'assistances.type']);

        if (!empty($request->query('force')) && $request->query('force') != 'all') {
            $query->selectRaw('martyrs.force')->where('martyrs.force', $request->query('force'))
            ->groupBy(['martyrs.force', 'assistances.status', 'assistances.type']);
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector', 'assistances.status', 'assistances.type']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->selectRaw('addresses.locality as locality')->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'assistances.status', 'assistances.type']);
        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(assistances.created_at) as month')->whereMonth('assistances.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(assistances.created_at) as year')->whereYear('assistances.created_at',  $request->query('year'))->groupBy('year');
        } 

        $report = $query->get()->groupBy(['status', 'type']);
        
        return view('reports.assistancesReport', compact('report'));
    }
    
}
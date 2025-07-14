<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\BailRequest;
use App\Models\Bail;
use App\Models\{Family, Martyr};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BailController extends Controller
{

    protected Family $family;
    protected Bail $bail;
    protected Martyr $martyr;
    protected $log;
    protected $returnToRoute = 'families.show';


    public function __construct()
    {
        $this->family   = new Family;
        $this->bail = new Bail;
        $this->martyr = new Martyr;
        $this->log  = Log::stack(['stack' => Log::build(['driver' => 'single', 'path' => storage_path('logs/alshahiid.log')]) ]);
    }

    public function index()
    {
        
        $request = request();

        $needel = trim(e($request->query('needel')));

        $query = DB::table('bails')
                ->join('families', 'bails.family_id', 'families.id')
                ->leftJoin('addresses', 'addresses.family_id', 'bails.family_id')
                ->leftJoin('martyrs', 'martyrs.id', 'families.martyr_id')
                ->selectRaw('
                    martyrs.force,
                    addresses.sector as sector,
                    addresses.locality as locality,
                    bails.status as status,
                    bails.type as type,
                    bails.provider as provider,
                    bails.budget as  budget,  
                    bails.budget_from_org as budget_from_org,
                    bails.budget_out_of_org  as budget_out_of_org,                   
                    bails.created_at  as created_at,                   
                    martyrs.name as martyr_name,
                    families.category as category
                ', 
                )->groupBy([
                    'addresses.sector', 'addresses.locality', 'martyrs.name', 'martyrs.force', 'addresses.sector', 'addresses.locality', 'bails.status', 'bails.type', 'bails.provider', 'budget', 'budget_from_org', 'budget_out_of_org', 'created_at', 'category'
                ]);

        if ($request->query('search') == 'martyr_name') {
            $query->where('martyrs.name', 'LIKE', "%$needel%");
        }

        if ($request->query('search') == 'force') {
            $query->where('martyrs.force', 'LIKE', "%$needel%");
        }

        if ($request->query('search') == 'category') {
            $query->where('families.category', 'LIKE', "%$needel%");
        }

        if (!empty($request->query('type')) && $request->query('type') != 'all') {
            $query->where('bails.type', $request->query('type'));
        } 

        if (!empty($request->query('status')) && $request->query('status') != 'all') {
            $query->where('bails.status', $request->query('status'));
        } 

        if (!empty($request->query('provider')) && $request->query('provider') != 'all') {
            $query->where('bails.provider', $request->query('provider'));
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(bails.created_at) as month')->whereMonth('bails.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(bails.created_at) as year')->whereYear('bails.created_at',  $request->query('year'))->groupBy('year');
        } 

        
        // $totalBudget = $query->sum('bails.budget');
        // $totalBudgetFromOrg = $query->sum('bails.budget_from_org');
        // $totalBudgetOutOfOrg = $query->sum('bails.budget_out_of_org');
        // $totalMoney = $totalBudgetFromOrg + $totalBudgetOutOfOrg;

        $bails = $query->latest('bails.created_at')->paginate(); 
        
        return view('bails.index', compact('bails'));

    }

    public function create(int $family)
    {
        return view('bails.create', ['family' => $this->family->findOrFail($family)]);
    }

    public function store(BailRequest $request, int $family)
    {
        $data = $request->validated();

        try {
            $family = $this->family->findOrFail($family);
            $family->bails()->create($data);
            return back()->with('success', 'تم اضافة بيانات الكفالة بنجاح');
        } catch (Exception $e) {
            $this->log->error('Store Bail to family id='.$family, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }


    public function edit($id)
    {
        return view('bails.edit', ['bail' => $this->bail->findOrFail($id)->loadMissing('family.martyr')]);
    }


    public function show(int $family)
    {
        $request = request();

        $query = DB::table('bails')
            ->join('families', 'families.id', 'bails.family_id')
            ->join('martyrs', 'families.martyr_id', 'martyrs.id')
            ->select(
                'martyrs.name as name',
                'martyrs.id as martyr_id',
                'bails.*',
            )->where('families.id', $family);

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(bails.created_at) as month')->whereMonth('bails.created_at',  $request->query('month'));
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(bails.created_at) as year')->whereYear('bails.created_at',  $request->query('year'));
        } 

        if (!is_null($request->query('type')) && $request->query('type') != 'all') {
            $query->where('bails.type',  $request->query('type'));
        } 

        if (!is_null($request->query('status')) && $request->query('status') != 'all') {
            $query->where('bails.status',  $request->query('status'));
        } 

        if (!is_null($request->query('provider')) && $request->query('provider') != 'all') {
            $query->where('bails.provider',  $request->query('provider'));
        } 

        $totalBudget = $query->sum('bails.budget');
        $totalBudgetFromOrg = $query->sum('bails.budget_from_org');
        $totalBudgetOutOfOrg = $query->sum('bails.budget_out_of_org');
        $totalMoney = $totalBudgetFromOrg + $totalBudgetOutOfOrg;
        $martyrName = $this->family->findOrFail($family)->martyr->name;
        
        $bails = $query->latest('bails.created_at')->paginate(10)->appends(['bails' => request('page')]);

        return view('families.bails', compact('bails', 'totalBudget', 'totalBudgetFromOrg', 'totalBudgetOutOfOrg', 'totalMoney', 'martyrName'));
    }


    public function update(BailRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $this->bail->findOrFail($id)->update($data);
            return back()->with('success', 'تم تعديل بيانات الكفالة بنجاح');
        } catch (Exception $e) {
            $this->log->error('Bail update  id='.$id, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }


    public function delete($id) 
    {
        return view('bails.delelte', ['bail' => $this->bail->findOrFail($id)]);
    }

    public function destroy($id)
    {
        $bail     = $this->bail->findOrFail($id);
        $familyId = $bail->family_id;
        $bail->delete();
        return to_route($this->returnToRoute, $familyId)->with('success', 'تم حذف بيانات الكفالة بنجاح');
    }

    public function report() 
    {
        
        $request = request();

        $query = DB::table('bails')
                ->leftJoin('addresses', 'addresses.family_id', 'bails.family_id')
                ->selectRaw('
                    bails.status as status,
                    bails.type as type,
                    SUM(bails.budget) as  budget,  
                    SUM(bails.budget_from_org) as budget_from_org,
                    SUM(bails.budget_out_of_org)  as budget_out_of_org,                   
                    SUM(bails.budget_out_of_org + bails.budget_from_org)  as totalMoney,
                    COUNT(bails.status) as count
                ', 
                )->groupBy(['bails.status', 'bails.type']);


        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector', 'bails.status', 'bails.type']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->selectRaw('addresses.locality as locality')->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'bails.status', 'bails.type']);
        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(bails.created_at) as month')->whereMonth('bails.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(bails.created_at) as year')->whereYear('bails.created_at',  $request->query('year'))->groupBy('year');
        } 

        $report = $query->get()->groupBy(['type', 'status']); 
        
        return view('reports.bails', compact('report'));
    }

}

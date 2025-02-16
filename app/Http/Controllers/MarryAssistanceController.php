<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\MarryAssistanceRquest;
use App\Models\MarryAssistance;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MarryAssistanceController extends Controller
{
    protected $channel;
    protected $log;

    public function __construct() 
    {
        $this->channel = Log::build(['driver' => 'single', 'path' => storage_path('logs/alshahiid.log')]);
        $this->log     = Log::stack(['stack' => $this->channel]);
    }

    public function create($member)
    {
        return view('marryAssistances.create', ['member' => FamilyMember::findOrFail($member)]);
    }

    public function store(MarryAssistanceRquest $request, int $member)
    {
        $data = $request->validated();

        try {
            $member = FamilyMember::findOrFail($member);
            $member->marryAssistances()->create($data);
            return back()->with('success', 'تم اضافة الخدمة بنجاح');
        } catch (Exception $e) {
            $this->log->error('Storing marray assistances of ' . $member->name, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        return view('marryAssistances.edit', ['marryAssistance' => MarryAssistance::findOrFail($id)->loadMissing('familyMember')]);
    }


    public function update(MarryAssistanceRquest $request, $id)
    {
        $data = $request->validated();

        try {
            $assit = MarryAssistance::findOrFail($id)->update($data);
            return back()->with('success', 'تم تعديل الخدمة بنجاح');
        } catch (Exception $e) {
            $this->log->error('Updating marray assistances ' . $assit->loadMissing('familyMember')->familyMember->name, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }   

    public function delete($id)
    {
        return view('marryAssistances.delete', ['marryAssistance' => MarryAssistance::findOrFail($id)]);
    }

    public function destroy($id)
    {
        try {
            $marry = MarryAssistance::findOrFail($id);
            $memberId = $marry->familyMember->id;
            $marry->delete();
            return to_route('familyMembers.show', $memberId)->with('success', 'تم حذف خدمة الزواج بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function report()
    {
        $request = request();

        $query = DB::table('marry_assistances')
                ->join('family_members',  'family_members.id', 'marry_assistances.family_member_id')
                ->join('families',  'families.id', 'family_members.family_id')
                ->join('martyrs','martyrs.id', 'families.martyr_id')
                ->join('addresses', 'addresses.family_id', 'families.id')
                ->selectRaw('
                    family_members.relation as relation,
                    marry_assistances.status as status,
                    SUM(marry_assistances.budget) as  budget,  
                    SUM(marry_assistances.budget_from_org) as budget_from_org,
                    SUM(marry_assistances.budget_out_of_org)  as budget_out_of_org,                   
                    SUM(marry_assistances.budget_out_of_org + marry_assistances.budget_from_org)  as totalMoney,
                    COUNT(marry_assistances.status) as count
                ', 
                )->groupBy(['marry_assistances.status', 'relation']);


       
        if (!empty($request->query('category')) && $request->query('category') != 'all') {
            $query->selectRaw('families.category as category')->where('families.category', $request->query('category'))
            ->groupBy(['families.category', 'marry_assistances.status']);
        } 


        if (!empty($request->query('relation')) && $request->query('relation') != 'all') {
            $query->where('family_members.relation', $request->query('relation'))->groupBy(['family_members.relation', 'marry_assistances.status']);
        }
        
        if (!empty($request->query('force')) && $request->query('force') != 'all') {
            $query->selectRaw('martyrs.force')->where('martyrs.force', $request->query('force'))->groupBy(['martyrs.force', 'marry_assistances.status']);
        }

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector', 'marry_assistances.status']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->selectRaw('addresses.locality as locality')->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'marry_assistances.status']);
        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(marry_assistances.created_at) as month')->whereMonth('marry_assistances.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(marry_assistances.created_at) as year')->whereYear('marry_assistances.created_at',  $request->query('year'))->groupBy('year');
        } 

        $report = $query->latest('marry_assistances.created_at')->get()->groupBy(['relation', 'status']);

        return view('reports.marriesAssistancesReport', compact('report'));
    }


}


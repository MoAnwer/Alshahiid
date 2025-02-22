<?php

namespace App\Http\Controllers;

use Exception;
use PDOException;
use Illuminate\Http\Request;
use App\Models\MedicalTreatment;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\DB;

class MedicalTreatmentController extends Controller
{

    public function index()
    {
        $request = request();

        $needel  = $request->query('needel');

        $query = DB::table('family_members')
                ->join('families', 'families.id', 'family_members.family_id')
                ->join('medical_treatments', 'medical_treatments.family_member_id', 'family_members.id')
                ->leftJoin('addresses', 'addresses.family_id', 'family_members.family_id')
                ->leftJoin('martyrs', 'martyrs.id', '=', 'families.martyr_id')
                ->select(
                    'family_members.name as name',
                    'family_members.gender as gender',
                    'family_members.relation as relation',
                    'family_members.health_insurance_number as health_insurance_number',
                    'addresses.sector as sector',
                    'addresses.locality as locality',
                    'families.martyr_id',
                    'families.id',
                    'medical_treatments.id as medicalTreatment_id',
                    'medical_treatments.type as type',
                    'medical_treatments.status as status',
                    'medical_treatments.budget as budget',
                    'medical_treatments.budget_from_org as budget_from_org',
                    'medical_treatments.budget_out_of_org as budget_out_of_org',
                    'medical_treatments.created_at as created_at',
                    'martyrs.name as martyr_name',
                    'martyrs.force as force',
                );

        if ($request->query('search') == 'martyr_name') {
            $query->where('martyrs.name',  'LIKE', "%{$needel}%");
        }

        if ($request->query('search') == 'force') {
            $query->where('martyrs.force',  'LIKE', "%{$needel}%");
        }

        if ($request->query('search') == 'name') {
            $query->where('family_members.name',  'LIKE', "%{$needel}%");
        }

        if (!empty($request->query('relation')) && $request->query('relation') != 'all') {
            $query->where('family_members.relation', $request->query('relation'));
        } 

        if(!empty($request->query('gender')) && $request->query('gender') != 'all') {
            $query->where('family_members.gender', $request->query('gender'));
        }

        if (!empty($request->query('type')) && $request->query('type') != 'all') {
            $query->where('medical_treatments.type', $request->query('type'));
        } 

        if (!empty($request->query('status')) && $request->query('status') != 'all') {
            $query->where('medical_treatments.status', $request->query('status'));
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        if (!empty($request->query('year')) && $request->query('year') != 'all') {
            $query->whereYear('medical_treatments.created_at', $request->query('year'));
        } 

        if (!empty($request->query('month')) && $request->query('month') != 'all') {
            $query->whereMonth('medical_treatments.created_at', $request->query('month'));
        } 

        $medicalTreatments = $query->latest('medical_treatments.id')->paginate(10);

        return view('medicalTreatments.index', compact('medicalTreatments'));
    }

    public function tamiinList()
    {
        $request = request();

        $needel  = $request->query('needel');

        $query = DB::table('family_members')
                ->join('families', 'families.id', 'family_members.family_id')
                ->leftJoin('addresses', 'addresses.family_id', 'family_members.family_id')
                ->leftJoin('martyrs', 'martyrs.id', '=', 'families.martyr_id')
                ->select(
                    'family_members.name as name',
                    'family_members.gender as gender',
                    'family_members.relation as relation',
                    'family_members.health_insurance_number as health_insurance_number',
                    'family_members.health_insurance_start_date as health_insurance_start_date',
                    'family_members.health_insurance_end_date as health_insurance_end_date',
                    'addresses.sector as sector',
                    'addresses.locality as locality',
                    'families.martyr_id',
                    'family_members.id as member_id',
                    'family_members.created_at as created_at',
                    'martyrs.name as martyr_name',
                    'martyrs.force as force',
                );



        if ($request->query('search') == 'martyr_name') {
            $query->where('martyrs.name',  'LIKE', "%{$needel}%");
        }
        if ($request->query('search') == 'force') {
            $query->where('martyrs.force',  'LIKE', "%{$needel}%");
        }

        if ($request->query('search') == 'name') {
            $query->where('family_members.name',  'LIKE', "%{$needel}%");
        }

        
        if (!empty($request->query('hasTamiin')) && $request->query('hasTamiin') != 'all') {
            
            if ($request->query('hasTamiin') == 'yes') {

                $query->where(function ($q) {
                  $q->whereNotNull('family_members.health_insurance_number')
                    ->whereDate('family_members.health_insurance_end_date', '>', now());
                });

            } else if ($request->query('hasTamiin') == 'no') {

               $query->where(function ($q) {
                  $q->whereNull('family_members.health_insurance_number')
                    ->OrWhereDate('family_members.health_insurance_end_date', '<=', now());
                });
            }
        }
        
        if (!empty($request->query('gender')) && $request->query('gender') != 'all') {
            $query->where('family_members.gender', $request->query('gender'));
        } 

        if (!empty($request->query('relation')) && $request->query('relation') != 'all') {
            $query->where('family_members.relation', $request->query('relation'));
        }

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        if (!empty($request->query('year')) && $request->query('year') != 'all') {
            $query->whereYear('family_members.created_at', $request->query('year'));
        } 

        if (!empty($request->query('month')) && $request->query('month') != 'all') {
            $query->whereMonth('family_members.created_at', $request->query('month'));
        } 

        
        $medicalTreatments = $query->latest('family_members.id')->paginate(10);

        return view('medicalTreatments.tamiinList', compact('medicalTreatments'));

    }

    public function create(int $member)
    {
		try {
			
			$member = FamilyMember::findOrFail($member);

			return view('medicalTreatments.create', compact('member'));
			
		} catch (PDOException $e) {
			return $e->getMessage();
		} catch (Exception $e) {
			return abort(404);
		}
    }


    public function store(Request $request, int $member)
    {
        $data = $request->validate([
            'type'      		=> "required|in:التأمين الصحي,علاج خارج المظلة,علاج بالخارج",
            'status'            => 'required|in:مطلوب,منفذ',
            'budget'            => 'numeric|required',
            'budget_from_org'   => 'nullable|numeric',
            'budget_out_of_org' => 'nullable|numeric',           
            'notes'             => 'nullable|string',
            'provider'          => 'in:من داخل المنظمة,من خارج المنظمة'
        ], [
			'budget'			=> 'حقل المبلغ التقديري اجباري',
		]);
		
		try {
			$member = FamilyMember::findOrFail($member);
			
			$member->medicalTreatments()->create($data);
			
			return back()->with('success', 'تم اضافة الخدمة العلاجية بنجاح');
			
		} catch (PDOException $e) {
			return $e->getMessage();
			
		} catch (Exception $e) {
			return abort(404);
		}
		
    }


    public function edit(int $id)
    {
		try {
			return view('MedicalTreatments.edit', ['medicalTreatment' => MedicalTreatment::findOrFail($id)]);
		} catch (Exception $e) {
			return abort(404);
		}
        

    }

    public function update(Request $request, $id)
    {

        $data = $request->validate([
            'type'      		=> "required|in:التأمين الصحي,علاج خارج المظلة,علاج بالخارج",
            'status'            => 'required|in:مطلوب,منفذ',
            'budget'            => 'numeric|required',
            'budget_from_org'   => 'nullable|numeric',
            'budget_out_of_org' => 'nullable|numeric',           
            'notes'             => 'nullable|string',
            'provider'          => 'in:من داخل المنظمة,من خارج المنظمة'
        ], [
			'budget'			=> 'حقل المبلغ التقديري اجباري',
		]);
		
		try {
			
			$medical = MedicalTreatment::findOrFail($id);
            $medical->update($data);

            
            
			return back()->with('success', 'تم اضافة الخدمة العلاجية بنجاح');
			
		} catch (PDOException $e) {
			return $e->getMessage();
			
		} catch (Exception $e) {
			return abort(404);
		}
    }
	
	public function delete(int $id) 
	{
		try {
			return view('MedicalTreatments.delete', ['medicalTreatment' => MedicalTreatment::findOrFail($id)]);
		} catch (Exception $e) {
			return abort(404);
		} 
	}

    public function destroy($id)
    {
        try {
			$medicalTreatment = MedicalTreatment::findOrFail($id);
			$member = $medicalTreatment->familyMember->id;
			$medicalTreatment->delete();
			return to_route('familyMembers.show',  $member)->with('success', 'تم الحذف بنجاح');
		} catch (Exception $e) {
			return $e->getMessage();
		}
    }


    /**
     * التأمين الصحي دا التقرير بتاعو
     */

    public function tamiin() {

        $request = request();
        

        $hasTamiin = DB::table('family_members')
                    ->join('families', 'family_members.family_id', 'families.id')
                    ->join('martyrs', 'families.martyr_id', 'martyrs.id')
                    ->leftJoin('addresses', 'addresses.family_id', 'family_members.family_id')
                    ->selectRaw('COUNT(family_members.id) as count')
                    ->where('family_members.health_insurance_number', '!=', null);
        
        $hasNoTamiin = DB::table('family_members')
                       ->join('families', 'family_members.family_id', 'families.id')
                       ->join('martyrs', 'families.martyr_id', 'martyrs.id')
                       ->leftJoin('addresses', 'addresses.family_id', 'family_members.family_id')
                       ->selectRaw('COUNT(family_members.id) as count')
                       ->where('family_members.health_insurance_number', '=', null);

        
        if (!empty($request->query('force')) && $request->query('force') != 'all') {
            $hasTamiin->selectRaw('martyrs.force')->where('martyrs.force', $request->query('force'))
            ->groupBy(['martyrs.force']);

            $hasNoTamiin->selectRaw('martyrs.force')->where('martyrs.force', $request->query('force'))
            ->groupBy(['martyrs.force']);
        } 

        if (!empty($request->query('gender')) && $request->query('gender') != 'all') {

            $hasTamiin->selectRaw('family_members.gender as gender')->where('gender', $request->query('gender'))
            ->groupBy(['martyrs.force', 'family_members.gender']);

            $hasNoTamiin->selectRaw('family_members.gender as gender')->where('gender', $request->query('gender'))
            ->groupBy(['martyrs.force', 'family_members.gender']);
        } 
 
        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {

            $hasTamiin->where('sector', $request->query('sector'))
            ->groupBy(['martyrs.force', 'family_members.gender', 'addresses.sector']);

            $hasNoTamiin->where('sector', $request->query('sector'))->groupBy(['martyrs.force', 'family_members.gender', 'addresses.sector']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {

            $hasTamiin->where('locality', $request->query('locality'))->groupBy(['martyrs.force', 'family_members.gender',  'addresses.sector']);

            $hasNoTamiin->where('locality', $request->query('locality'))->groupBy(['martyrs.force', 'family_members.gender',  'addresses.sector']);
        } 

        // $hasNoTamiin = $hasNoTamiin->get();

        // dd();

        $tamiin = 0;
        $notamiin = 0;

        foreach ($hasTamiin->get() as $key) {
            $tamiin += $key->count;
        }

        foreach ($hasNoTamiin->get() as $key) {
            $notamiin += $key->count;
        }
        

        $hasTamiin = $tamiin;
        $hasNoTamiin = $notamiin;

        // dd($tamiin);

        $report = collect([
            'has'       => @$hasTamiin,
            'no'        => @$hasNoTamiin,
            'total'     => @$hasTamiin  + @$hasNoTamiin
        ]);

        return view('MedicalTreatments.tamiin', compact('report'));

    }



    public function report()
    {
        $request    = request();
        
        $query = DB::table('family_members')
                ->join('families', 'family_members.family_id', 'families.id')
                ->join('martyrs', 'families.martyr_id', 'martyrs.id')
                ->join('medical_treatments', 'medical_treatments.family_member_id', 'family_members.id')
                ->leftJoin('addresses', 'addresses.family_id', 'family_members.family_id')
                ->selectRaw('
                    medical_treatments.status as status,
                    medical_treatments.type as type,
                    SUM(medical_treatments.budget) as totalBudget,  
                    SUM(medical_treatments.budget_from_org) as budget_from_org,
                    SUM(medical_treatments.budget_out_of_org)  as budget_out_of_org,                   
                    SUM(medical_treatments.budget_out_of_org + medical_treatments.budget_from_org)  as totalMoney,
                    COUNT(medical_treatments.id) as count
                ', 
                )->groupBy(['medical_treatments.type', 'medical_treatments.status']);

        if (!empty($request->query('force')) && $request->query('force') != 'all') {
            $query->selectRaw('martyrs.force')->where('martyrs.force', $request->query('force'))
            ->groupBy(['martyrs.force', 'medical_treatments.status', 'medical_treatments.type']);
        } 


        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector', 'medical_treatments.status', 'medical_treatments.type']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->selectRaw('addresses.locality as locality')->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'medical_treatments.status', 'medical_treatments.type']);
        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(medical_treatments.created_at) as month')->whereMonth('medical_treatments.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(medical_treatments.created_at) as year')->whereYear('medical_treatments.created_at',  $request->query('year'))->groupBy('year');
        } 

        $report = $query->get()->groupBy(['type', 'status']);

        
        $report = collect([
            'tamiin'            =>    [
                'need'   => $report->has('التأمين الصحي') ? $report->get('التأمين الصحي')->get('مطلوب') : null,
                'done'   => $report->has('التأمين الصحي') ? $report->get('التأمين الصحي')->get('منفذ') : null
            ],
            'outTeatments'      =>  [
                'need'   => $report->has('علاج بالخارج') ? $report->get('علاج بالخارج')->get('مطلوب') : null,
                'done'   => $report->get('علاج بالخارج') ? $report->get('علاج بالخارج')->get('منفذ') : null
            ],
            'teatmentsOutOfOrg'  => [
                'need'   => $report->has('علاج خارج المظلة') ? $report->get('علاج خارج المظلة')->get('مطلوب') : null,
                'done'   => $report->has('علاج خارج المظلة') ? $report->get('علاج خارج المظلة')->get('منفذ') : null
            ]
        ]);


        return view('reports.medicalTreatments', compact('report'));
    }
}

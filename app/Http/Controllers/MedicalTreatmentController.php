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
		//dd($request->all());
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
			
			MedicalTreatment::where('id', $id)->update($data);			
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

    public function report()
    {

        $request    = request();


        $report = collect(DB::select('
                                SELECT 
                                    SUM(m.budget) as totalBudget,
                                    m.status, 
                                    COUNT(m.status) as count, 
                                    m.type,
                                    SUM(m.budget_from_org)  as budget_from_org,
                                    SUM(m.budget_out_of_org) as budget_out_of_org,
                                    addresses.sector,
                                    addresses.locality
                                FROM
                                    family_members
                                INNER JOIN
                                    medical_treatments m
                                ON
                                    m.family_member_id = family_members.id

                                INNER JOIN
                                    families
                                ON
                                    families.id = family_members.family_id
                                INNER JOIN
                                    addresses
                                ON
                                    addresses.family_id = families.id

                                WHERE addresses.sector = ? AND addresses.locality = ?

                                GROUP BY
                                    m.type, m.status, addresses.sector,addresses.locality

        ', [$request->query('sector') ?? 'القاش', $request->query('locality') ?? 'كسلا']));

         $report = $report->groupBy('type');


        $report = collect([
            'tamiin'            =>    [
                'need'   => $report->has('التأمين الصحي') ? $report->get('التأمين الصحي')->groupBy('status')->get('مطلوب') : null,
                'done'   => $report->has('التأمين الصحي') ? $report->get('التأمين الصحي')->groupBy('status')->get('منفذ') : null
            ],
            'outTeatments'      =>  [
                'need'   => $report->has('علاج بالخارج') ? $report->get('علاج بالخارج')->groupBy('status')->get('مطلوب') : null,
                'done'   => $report->get('علاج بالخارج') ? $report->get('علاج بالخارج')->groupBy('status')->get('منفذ') : null
            ],
            'teatmentsOutOfOrg'  => [
                'need'   => $report->has('علاج خارج المظلة') ? $report->get('علاج خارج المظلة')->groupBy('status')->get('مطلوب') : null,
                'done'   => $report->has('علاج خارج المظلة') ? $report->get('علاج خارج المظلة')->groupBy('status')->get('منفذ') : null
            ]
        ]);

         //dd($report);

        return view('reports.medicalTreatments', compact('report'));
    }
}

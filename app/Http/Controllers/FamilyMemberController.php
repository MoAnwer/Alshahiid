<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Services\FamilyMemberService;
use App\Http\Requests\FamilyMemberRequest;
use Illuminate\Support\Facades\Log;

class FamilyMemberController extends Controller
{
    protected $log;
    protected Family $family;
    protected FamilyMember $member;
    protected FamilyMemberService $memberService;

    public function __construct() 
    {
        $this->family  = new Family;
        $this->member  = new FamilyMember;
        $this->memberService = new FamilyMemberService;
        $this->log  = Log::stack(['stack' => Log::build(['driver' => 'single', 'path' => storage_path('logs/alshahiid.log')]) ]);
    }

    public function create(int $family)
    {  
        try {

            return view('familyMembers.create', ['family' => $this->family->findOrFail($family)->loadMissing('martyr')]);

        } catch(Exception $e) {
            $this->log->error('Create family member to family id=' .$family, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
        
    }

    public function store(FamilyMemberRequest $request, int $family)
    {
		$data = $request->validated();

        try {
        
            if($request->hasFile('personal_image')) {
                $imageName = str()->orderedUuid() . '.' . $request->file('personal_image')->getClientOriginalExtension();
                $request->file('personal_image')->move(public_path('uploads/images'), $imageName);

                $data['personal_image'] = $imageName;

                $this->family->findOrFail($family)->familyMembers()->create($data);
                
                return back()->with('success', 'تم اضافة الفرد بنجاح');
            }

            $this->family->findOrFail($family)->familyMembers()->create($data);
        
            return back()->with('success', 'تم اضافة الفرد بنجاح');

        } catch (Exception $e) {
            $this->log->error('Storing family member to family id=' .$family, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
     
    }

    public function show(int $id)
    {
        $member = $this->member->findOrFail($id);
        
        try {
            $member = $member->loadMissing(['family.martyr', 'student', 'medicalTreatments', 'documents', 'hags', 'marryAssistances']);
            
            return view('familyMembers.show', compact('member'));
            
        } catch (Exception $e) {
            $this->log->error('Showing family member id=' .$id, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }

    public function edit(int $member)
    {
        try {
            return view('familyMembers.edit', ['familyMember' => $this->member->findOrFail($member)]);
        } catch (Exception $e) {
            $this->log->error('Storing family member id=' .$member, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        $data = [];

        if(isset($request->national_number) && isset($request->health_insurance_number)) {
		    $data = $request->validate([
                "name" => 'string|required',
                "age" => 'integer|required',
                "gender" => "in:ذكر,أنثى",
                "relation" => "in:اب,ام,اخ,اخت,زوجة,ابن,ابنة",
                "national_number" => "required|numeric|unique:family_members,national_number",
                "phone_number" => "string|nullable",
                "birth_date" => "date|required",
                "health_insurance_number" => "numeric|nullable|unique:family_members,health_insurance_number",
                "health_insurance_start_date" => "date|nullable",
                "health_insurance_end_date" => "date|nullable",
                'personal_image' => 'image:mimes:jpg,png,jpeg,gif|nullable',
            ], [
                'name'              => 'حقل الاسم اجباري',
                'age'               => 'حقل العمر اجباري' ,
                'national_number'   => 'الرقم الوطني اجباري',
                'birth_date'        => 'تاريخ الميلاد اجباري',
                'health_insurance_number.unique'   => 'رقم بطاقة التأمين الصحي  موجود بالفعل',
                'national_number.unique'   => 'الرقم الوطني موجود بالفعل',
            ]);
        } else if(isset($request->national_number)) {
            $data = $request->validate([
                "name" => 'string|required',
                "age" => 'integer|required',
                "gender" => "in:ذكر,أنثى",
                "relation" => "in:اب,ام,اخ,اخت,زوجة,ابن,ابنة",
                "national_number" => "required|numeric|unique:family_members,national_number",
                "phone_number" => "string|nullable",
                "birth_date" => "date|required",
                "health_insurance_start_date" => "date|nullable",
                "health_insurance_end_date" => "date|nullable",
                'personal_image' => 'image:mimes:jpg,png,jpeg,gif|nullable',
            ], [
                'name'              => 'حقل الاسم اجباري',
                'age'               => 'حقل العمر اجباري' ,
                'national_number'   => 'الرقم الوطني اجباري',
                'birth_date'        => 'تاريخ الميلاد اجباري',
                'national_number.unique'   => 'الرقم الوطني موجود بالفعل',
            ]);
        } else if (isset($request->health_insurance_number)) {
            $data = $request->validate([
                "name" => 'string|required',
                "age" => 'integer|required',
                "gender" => "in:ذكر,أنثى",
                "relation" => "in:اب,ام,اخ,اخت,زوجة,ابن,ابنة",
                "phone_number" => "string|nullable",
                "birth_date" => "date|required",
                "health_insurance_number" => "numeric|nullable|unique:family_members,health_insurance_number",
                "health_insurance_start_date" => "date|nullable",
                "health_insurance_end_date" => "date|nullable",
                'personal_image' => 'image:mimes:jpg,png,jpeg,gif|nullable',
            ], [
                'name'              => 'حقل الاسم اجباري',
                'age'               => 'حقل العمر اجباري' ,
                'national_number'   => 'الرقم الوطني اجباري',
                'birth_date'        => 'تاريخ الميلاد اجباري',
                'health_insurance_number.unique'   => 'رقم بطاقة التأمين الصحي  موجود بالفعل',
                'national_number.unique'   => 'الرقم الوطني موجود بالفعل',
            ]);
        } else {
            $data = $request->validate([
                "name" => 'string|required',
                "age" => 'integer|required',
                "gender" => "in:ذكر,أنثى",
                "relation" => "in:اب,ام,اخ,اخت,زوجة,ابن,ابنة",
                "phone_number" => "string|nullable",
                "birth_date" => "date|required",
                "health_insurance_start_date" => "date|nullable",
                "health_insurance_end_date" => "date|nullable",
                'personal_image' => 'image:mimes:jpg,png,jpeg,gif|nullable',
            ], [
                'name'              => 'حقل الاسم اجباري',
                'age'               => 'حقل العمر اجباري' ,
                'national_number'   => 'الرقم الوطني اجباري',
                'birth_date'        => 'تاريخ الميلاد اجباري',
                'health_insurance_number.unique'   => 'رقم بطاقة التأمين الصحي  موجود بالفعل',
                'national_number.unique'   => 'الرقم الوطني موجود بالفعل',
            ]); 
        }
			
        try {

            $familyMember = $this->member->findOrFail($id);
            
            if($request->hasFile('personal_image')) {

                @unlink(public_path('uploads/images/'.$familyMember->personal_image));
                

                $imageName = str()->orderedUuid() . '.' . $request->file('personal_image')->getClientOriginalExtension();                

                $request->file('personal_image')->move(public_path('uploads/images'), $imageName);

                $data['personal_image'] = $imageName;

                $familyMember->update($data);

                
                
                return back()->with('success', 'تم تعديل  بيانات  '. $familyMember->name .' بنجاح');
            }

            $familyMember->update($data);

            
        
            return back()->with('success', 'تم تعديل  بيانات  '. $familyMember->name .' بنجاح');

        } catch (Exception $e) {
            $this->log->error('Updating family member id=' .$id, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }

    }
	
	
	public function delete(int $id) 
	{
		return view('familyMembers.delete', ['member' => $this->member->findOrFail($id)]);
	}

    public function destroy($id)
    {
        try {
            $familyMember = $this->member->findOrFail($id);
            $familyId = $familyMember->family->id;
            $name = $familyMember->name;
            @unlink(public_path('uploads/images/'.$familyMember->personal_image));
            $familyMember->delete();

            

            return to_route('families.show', $familyId)->with('success', 'تم حذف الفرد  '. $name .' بنجاح');
        } catch (Exception $e) {
            $this->log->error('Updating family member id=' .$id, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }

    public function familyMembersCountReport()
    {
        return view('reports.familyMembersCountReport', $this->memberService->familyMembersCountReport());
    }


    public function familyMembersCountByCategoryReport()
    {
        
        return view('reports.familyMembersCountByCategoryReport', $this->memberService->familyMembersCountByCategoryReport());
    }


    public function orphanReport()
    {
        return view('reports.orphanReport', $this->memberService->orphanReport());

    }


}

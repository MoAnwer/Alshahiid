<?php

namespace App\Http\Controllers;

use App\Models\FamilyMember;
use Illuminate\Support\Facades\DB;


class OrphanController extends Controller
{
    protected FamilyMember $member;

    public function __construct()
    {
        $this->member = new FamilyMember;
    }


    public function index() 
    {
        return view('orphans.index');
    }

    /**
     * orphansList function
     *  this is education 
     * @return Illuminate\Support\Facades\View
     **/

    public function orphansList()
    {
        $request = request();

        $query = DB::table('family_members')
                ->join('families', 'family_members.family_id', '=', 'families.id')
                ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                ->leftJoin('students', 'students.family_member_id', '=', 'family_members.id')
                ->leftJoin('martyrs', 'martyrs.id', '=', 'families.martyr_id')
                ->select(
                    'addresses.sector as sector',
                    'addresses.locality as locality',
                    'families.martyr_id',
                    'families.id as family_id',
                    'martyrs.name as martyr_name',
                    'martyrs.force as force',
                    'family_members.id as orphan_id',
                    'students.stage as stage',
                    'students.class as class',
                    'students.school_name as school_name',
                    'family_members.name as name',
                    'family_members.age as age',
                    'family_members.national_number as national_number',
                    'family_members.personal_image as personal_image',
                    'family_members.relation as relation',
                    'family_members.family_id as family_id'
                )
                ->whereIn('family_members.relation', ['ابن', 'ابنة'])
                ->where('family_members.age', '<=', 18);

        $needel = trim(htmlentities($request->query('needel')));

        if ($request->query('search') == 'name') {
            $query->where('family_members.name', 'LIKE', "%{$needel}%");
        }

        if($request->query('search') == 'age') {
            $query->where('family_members.age', $needel);
        }

        if ($request->query('search') == 'militarism_number') {
            $query->where('martyrs.militarism_number', $needel);
        }

        if($request->query('search') == 'national_number') {
            $query->where('family_members.national_number', $needel);
        }

        if($request->query('search') == 'stage') {
            $query->where('students.stage', $needel);
        }

        if($request->query('search') == 'class') {
            $query->where('students.class', $needel);
        }

        if($request->query('search') == 'school_name') {
            $query->where('students.school_name', $needel);
        }

        if($request->query('search') == 'force') {
            $query->where('martyrs.force', $needel);
        }

        if (!empty($request->query('gender')) && $request->query('gender') != 'all') {
            $query->where('family_members.gender', $request->query('gender'));
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        $orphans = $query->latest('orphan_id')->paginate(10); 

        return view('orphans.orphans-list', compact('orphans'));
    }

    /**
     * hags function
     *  this is education 
     * @return Illuminate\Support\Facades\View
     **/

    public function hags() 
    {
        $request = request();

        $needel = trim(htmlentities($request->query('needel')));

        $query = DB::table('family_members')
                ->leftJoin('families', 'family_members.family_id', '=', 'families.id')
                ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                ->rightJoin('hags', 'hags.family_member_id', '=', 'family_members.id')
                ->leftJoin('martyrs', 'martyrs.id', '=', 'families.martyr_id')
                ->select(
                    'addresses.sector as sector',
                    'addresses.locality as locality',
                    'family_members.id as orphan_id',
                    'families.martyr_id',
                    'families.id',
                    'hags.type as type',
                    'hags.status as status',
                    'hags.budget as budget',
                    'hags.budget_from_org as budget_from_org',
                    'hags.budget_out_of_org as budget_out_of_org',
                    'hags.created_at as created_at',
                    'martyrs.name as martyr_name',
                    'martyrs.force as force',
                    'family_members.name as name',
                    'family_members.age as age',
                    'family_members.national_number as national_number',
                    'family_members.relation as relation',
                    'family_members.phone_number as phone_number',
                    'family_members.family_id as family_id'
                )
                ->whereIn('family_members.relation', ['ابن', 'ابنة'])
                ->where('family_members.age', '<=', 18);


        if ($request->query('search') == 'name') {
            $query->where('family_members.name', 'LIKE', "%{$needel}%");
        }

        if ($request->query('search') == 'age') {
            $query->where('family_members.age', $needel);
        }

        if ($request->query('search') == 'national_number') {
            $query->where('family_members.national_number', $needel);
        }

        if ($request->query('search') == 'force') {
            $query->where('martyrs.force', $needel);
        }

        if ($request->query('search') == 'martyr_name') {
            $query->where('martyrs.name', $needel);
        }

        if (!empty($request->query('gender')) && $request->query('gender') != 'all') {
            $query->where('family_members.gender', $request->query('gender'));
        } 

        if (!empty($request->query('type')) && $request->query('type') != 'all') {
            $query->where('hags.type', $request->query('type'));
        } 

        if (!empty($request->query('status')) && $request->query('status') != 'all') {
            $query->where('hags.status', $request->query('status'));
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        if (!empty($request->query('year')) && $request->query('year') != 'all') {
            $query->whereYear('hags.created_at', $request->query('year'));
        } 

        if (!empty($request->query('month')) && $request->query('month') != 'all') {
            $query->whereMonth('hags.created_at', $request->query('month'));
        } 

        $orphans = $query->latest('hags.id')->paginate();

        return view('orphans.hags-report', compact('orphans'));
    }


   /**
     * medical function
     *  this is education 
     * @return Illuminate\Support\Facades\View
     **/

    public function medical() 
    {
        $request = request();

        $needel = trim(htmlentities($request->query('needel')));

        $query = DB::table('family_members')
                ->leftJoin('families', 'family_members.family_id', '=', 'families.id')
                ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                ->rightJoin('medical_treatments', 'medical_treatments.family_member_id', '=', 'family_members.id')
                ->leftJoin('martyrs', 'martyrs.id', '=', 'families.martyr_id')
                ->select(
                    'addresses.sector as sector',
                    'addresses.locality as locality',
                    'family_members.id as orphan_id',
                    'families.martyr_id',
                    'families.id',
                    'medical_treatments.type as type',
                    'medical_treatments.status as status',
                    'medical_treatments.budget as budget',
                    'medical_treatments.budget_from_org as budget_from_org',
                    'medical_treatments.budget_out_of_org as budget_out_of_org',
                    'medical_treatments.created_at as created_at',
                    'martyrs.name as martyr_name',
                    'martyrs.force as force',
                    'family_members.name as name',
                    'family_members.age as age',
                    'family_members.national_number as national_number',
                    'family_members.relation as relation',
                    'family_members.phone_number as phone_number',
                    'family_members.family_id as family_id'
                )
                ->whereIn('family_members.relation', ['ابن', 'ابنة'])
                ->where('family_members.age', '<=', 18);


        if ($request->query('search') == 'name') {
            $query->where('family_members.name', 'LIKE', "%{$needel}%");
        }

        if ($request->query('search') == 'age') {
            $query->where('family_members.age', $needel);
        }

        if ($request->query('search') == 'national_number') {
            $query->where('family_members.national_number', $needel);
        }
        
         if ($request->query('search') == 'force') {
            $query->where('martyrs.force', $needel);
        }

        if ($request->query('search') == 'martyr_name') {
            $query->where('martyrs.name', $needel);
        }

        if (!empty($request->query('gender')) && $request->query('gender') != 'all') {
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


        $orphans = $query->latest('medical_treatments.id')->paginate();

        return view('orphans.medical-report', compact('orphans'));
    }

    /**
     * education function
     *  this is education 
     * @return Illuminate\Support\Facades\View
     **/

    public function education() 
    {
        
        $request = request();

        $needel = trim(htmlentities($request->query('needel')));

        $query = DB::table('family_members')
                ->join('families', 'family_members.family_id', '=', 'families.id')
                ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                ->join('students', 'students.family_member_id', '=', 'family_members.id')
                ->join('education_services', 'education_services.student_id', '=', 'students.id')
                ->leftJoin('martyrs', 'martyrs.id', '=', 'families.martyr_id')
                ->select(
                    'addresses.sector as sector',
                    'addresses.locality as locality',
                    'families.martyr_id',
                    'families.id as family_id',
                    'martyrs.name as martyr_name',
                    'martyrs.force as force',
                    'family_members.id as orphan_id',
                    'education_services.type as type',
                    'education_services.created_at as created_at',
                    'students.stage as stage',
                    'education_services.status as status',
                    'education_services.budget as budget',
                    'education_services.budget_from_org as budget_from_org',
                    'education_services.budget_out_of_org as budget_out_of_org',
                    'family_members.name as name',
                    'family_members.age as age',
                    'family_members.national_number as national_number',
                    'family_members.relation as relation',
                    'family_members.phone_number as phone_number',
                    'family_members.family_id as family_id',
                )
                ->whereIn('family_members.relation', ['ابن', 'ابنة'])
                ->where('family_members.age', '<=', 18);

        if ($request->query('search') == 'name') {
            $query->where('family_members.name', 'LIKE', "%{$needel}%");
        }

        if ($request->query('search') == 'age') {
            $query->where('family_members.age', $needel);
        }

        if (!empty($request->query('gender')) && $request->query('gender') != 'all') {
            $query->where('family_members.gender', $request->query('gender'));
        } 

        if ($request->query('search') == 'national_number') {
            $query->where('family_members.national_number', $needel);
        }


        if ($request->query('search') == 'force') {
            $query->where('martyrs.force', $needel);
        }

        if ($request->query('search') == 'martyr_name') {
            $query->where('martyrs.name', $needel);
        }

        if (!empty($request->query('gender')) && $request->query('gender') != 'all') {
            $query->where('family_members.gender', $request->query('gender'));
        } 

        if (!empty($request->query('type')) && $request->query('type') != 'all') {
            $query->where('education_services.type', $request->query('type'));
        } 

        if (!empty($request->query('status')) && $request->query('status') != 'all') {
            $query->where('education_services.status', $request->query('status'));
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        if (!empty($request->query('year')) && $request->query('year') != 'all') {
            $query->whereYear('education_services.created_at', $request->query('year'));
        } 

         if (!empty($request->query('month')) && $request->query('month') != 'all') {
            $query->whereMonth('education_services.created_at', $request->query('month'));
        } 


        $orphans = $query->latest('education_services.id')->paginate();

        return view('orphans.education-report', compact('orphans'));
    }
}

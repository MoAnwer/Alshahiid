<?php

namespace App\Http\Controllers;

use App\Models\FamilyMember;
use Illuminate\Support\Facades\DB;

class WidowController extends Controller
{
    protected FamilyMember $member;

    public function __construct()
    {
        $this->member = new FamilyMember;
    }

    public function widows()
    {
        $request = request();

        $needel = trim(htmlentities($request->query('needel')));

        $query = DB::table('family_members')
                ->join('families', 'family_members.family_id', 'families.id')
                ->join('addresses', 'addresses.family_id', 'families.id')
                ->join('martyrs', 'martyrs.id', 'families.martyr_id')
                ->select(
                    'addresses.sector',
                    'addresses.locality',
                    'family_members.id as widow_id',
                    'families.martyr_id',
                    'families.id',
                    'martyrs.name as martyr_name',
                    'martyrs.force as force',
                    'family_members.name as name',
                    'family_members.age as age',
                    'family_members.national_number as national_number',
                    'family_members.personal_image as personal_image',
                    'family_members.relation as relation',
                    'family_members.phone_number as phone_number',
                    'family_members.family_id as family_id'
                )
                ->where('family_members.relation', 'زوجة')
                ->latest('widow_id');

       

        if($request->query('search') == 'name') {
            $query->where('name', 'LIKE', "%{$needel}%");
        }

        if($request->query('search') == 'age') {
            $query->where('age', $needel);
        }


        if($request->query('search') == 'national_number') {
            $query->where('national_number', $needel);
        }
        

        if($request->query('search') == 'force') {
            $query->where('martyrs.force', $needel);
        }
         if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        $widows = $query->paginate();

        return view('widows.index', compact('widows'));
    }
}

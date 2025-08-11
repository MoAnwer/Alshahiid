<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Family;
use App\Models\Supervisor;
use App\Models\Martyr;
use App\Services\FamilyService;
use Illuminate\Support\Facades\{Log, DB};

class FamilyController extends Controller
{
    protected $log;
    protected Martyr $martyr;
    protected Family $family;
    protected Supervisor $supervisor;
    protected FamilyService $familyService;

    public function __construct()
    {
        $this->family  = new Family;
        $this->martyr   = new Martyr;
        $this->supervisor  = new Supervisor;
        $this->familyService = new FamilyService;

        $this->log  = Log::stack(['stack' => Log::build(['driver' => 'single', 'path' => storage_path('logs/alshahiid.log')])]);
    }

    public function index()
    {

        $request = request();

        $needel = trim($request->query('needel'));

        $query = DB::table('families')
            ->leftJoin('supervisors', 'families.supervisor_id', '=', 'supervisors.id')
            ->leftJoin('addresses', 'addresses.family_id', 'families.id')
            ->leftJoin('family_members', 'family_members.family_id', 'families.id')
            ->join('martyrs', 'families.martyr_id', 'martyrs.id')
            ->selectRaw('
                    families.id as family_id,
                    families.category as category,
                    families.family_size as family_size,
                    martyrs.name as martyr_name,
                    martyrs.force,
                    supervisors.name as supervisor_name,
                    addresses.sector as sector,
                    addresses.locality as locality,
                    COUNT(family_members.id) as real_members_count
                ')->groupBy([
                'martyrs.name',
                'families.category',
                'families.id',
                'families.family_size',
                'supervisors.name',
                'addresses.sector',
                'locality',
                'martyrs.force'
            ]);


        if ($request->query('search') == 'martyr_name') {
            $query->where('martyrs.name', 'LIKE', "%$needel%");
        }

        if ($request->query('search') == 'militarism_number') {
            $query->where('martyrs.militarism_number', $needel);
        }

        if ($request->query('search') == 'force') {
            $query->where('martyrs.force', $needel);
        }


        if (!empty($request->query('category')) && $request->query('category') != 'all') {
            $query->where('families.category', $request->query('category'))->groupBy('families.category');
        }

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'))->groupBy('addresses.sector');
        }

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'))->groupBy(['addresses.sector', 'addresses.locality']);
        }

        if (!empty($request->query('year')) && $request->query('year') != 'all') {
            $query->whereYear('families.created_at', $request->query('year'));
        }

        if (!empty($request->query('month')) && $request->query('month') != 'all') {
            $query->whereMonth('families.created_at', $request->query('month'));
        }

        $families = $query->latest('families.id')->paginate();

        return view('families.familiesList', compact('families'));
    }


    /**
     * familiesMembersCount method return male, female, brother, sisters, orphans male and female count 
     */
    public function familiesMembersCount()
    {
        $request = request();

        $query = DB::table('families')
            ->leftJoin('supervisors', 'families.supervisor_id', '=', 'supervisors.id')
            ->join('addresses', 'addresses.family_id', 'families.id')
            ->leftJoin('family_members', 'family_members.family_id', 'families.id')
            ->join('martyrs', 'families.martyr_id', 'martyrs.id')
            ->selectRaw('
                    families.id as family_id,
                    families.category as category,
                    families.family_size as family_size,
                    martyrs.name as martyr_name,
                    supervisors.name as supervisor_name,
                    addresses.sector as sector,
                    addresses.locality as locality,
                    COUNT(CASE WHEN family_members.age <= 18 AND family_members.relation = "ابن" AND family_members.gender = "ذكر" THEN 1 END) AS male_orphans_count,
                    COUNT(CASE WHEN family_members.age <= 18 AND family_members.relation = "ابنة" AND family_members.gender = "أنثى" THEN 1 END) AS female_orphans_count,
                    COUNT(CASE WHEN family_members.relation = "اخ" AND family_members.gender = "ذكر" THEN 1 END) AS brothers_count,
                    COUNT(CASE WHEN family_members.relation = "اخت" AND family_members.gender = "أنثى" THEN 1 END) AS sisters_count,
                    COUNT(CASE WHEN family_members.gender = "ذكر" THEN 1 END) AS male_count,
                    COUNT(CASE WHEN family_members.gender = "أنثى" THEN 1 END) AS female_count
                ')->groupBy([
                'martyrs.name',
                'families.category',
                'families.id',
                'families.family_size',
                'supervisors.name',
                'addresses.sector',
                'locality'
            ]);


        if ($martyr_name = $request->query('martyr_name')) {
            $query->where('martyrs.name',  'LIKE', "%{$martyr_name}%")->orWhere('martyrs.militarism_number', $martyr_name);
        }

        if (!empty($request->query('category')) && $request->query('category') != 'all') {
            $query->where('families.category', $request->query('category'))->groupBy('families.category');
        }

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'))->groupBy('addresses.sector');
        }

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'))->groupBy(['addresses.sector', 'addresses.locality']);
        }

        if (!empty($request->query('year')) && $request->query('year') != 'all') {
            $query->whereYear('families.created_at', $request->query('year'));
        }

        if (!empty($request->query('month')) && $request->query('month') != 'all') {
            $query->whereMonth('families.created_at', $request->query('month'));
        }

        $families = $query->latest('families.id')->paginate();

        return view('families.families-members-count', compact('families'));
    }


    public function create(int $martyr)
    {
        return view('families.create', ['martyr' => $this->martyr->findOrFail($martyr)]);
    }


    public function store(Request $request, int $martyr)
    {
        $family = $request->validate(['category' => 'required', 'family_size' => 'required'], [
            'family_size'   => 'الرجاء ادخال عدد افراد الاسرة'
        ]);

        $address  = $request->validate([
            'sector'        => 'required',
            'locality'      => 'required',
            'type'          => 'required',
            'neighborhood'  => 'required'
        ], [
            'neighborhood'  => 'اسم الحي مطلوب'
        ]);

        try {

            $martyr = $this->martyr->findOrFail($martyr);
            $family = $martyr->family()->create($family);
            $family->address()->create($address);

            return to_route('families.show', $family->id)->with('success', 'تمت اضافة بيانات الاسرة بنجاح ✅👍🏼');
        } catch (Exception $e) {
            $this->log->error('Store family martyr id=' . $martyr, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        return view('families.martyrFamily', [
            'family' => $this->family->findOrFail($id)->loadMissing(['martyr', 'familyMembers', 'supervisor', 'addresses', 'communicate'])
        ]);
    }


    public function edit($id)
    {
        return view('families.edit', ['family' => $this->family->findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $familyData = $request->validate(['category' => 'required', 'family_size' => 'required'], [
            'family_size'   => 'الرجاء ادخال عدد افراد الاسرة'
        ]);

        try {

            $family = $this->family->findOrFail($id);
            $family->update($familyData);

            return to_route('families.show', $family->id)->with('success', 'تم تعديل بيانات الاسرة بنجاح ✅👍🏼');
        } catch (Exception $e) {

            $this->log->error('Update family id=' . $id, ['exception' => $e->getMessage()]);
            return  $e->getMessage();
        }
    }


    public function delete(int $id)
    {
        return view('families.delete', ['family' => $this->family->findOrFail($id)]);
    }



    public function destroy($id)
    {
        try {
            $family = $this->family->findOrFail($id);
            $martyrId = $family->martyr->id;
            $family->addresses()->delete();
            $family->delete();

            return to_route('martyrs.index', $martyrId)->with('success', 'تم حذف الاسرة بنجاح');
        } catch (Exception $e) {
            $this->log->error('Destroy family id=' . $id, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }

    public function createSupervisor($family)
    {
        return view('families.createSupervisor', ['family' => $this->family->findOrFail($family), 'supervisors' => $this->supervisor->selectRaw('id, name')->get()]);
    }

    public function storeSupervisor(Request $request, int $family)
    {
        $data = $request->validate([
            'supervisor_id'    => 'required|exists:supervisors,id'
        ]);

        try {

            $this->family->findOrFail($family)->update($data);


            return to_route('families.show', $family)->with('success', 'تم إضافة المشرف بنجاح');
        } catch (Exception $e) {
            $this->log->error('Store supervisor to family id=' . $family, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }


    public function editSupervisor(int $family)
    {
        return view('families.editSupervisor', [
            'family' => $this->family->findOrFail($family)->loadMissing(['martyr', 'supervisor']),
            'supervisors' => $this->supervisor->selectRaw('id, name')->get()
        ]);
    }


    public function deleteSupervisor(int $family)
    {
        return view('families.deleteSupervisor', [
            'family' => $this->family->findOrFail($family)->loadMissing(['martyr', 'supervisor'])
        ]);


        return to_route('families.show', $family)->with('success', 'تم تعديل المشرف بنجاح');
    }

    public function destroySupervisor(int $family)
    {
        try {
            $this->family->findOrFail($family)->update(['supervisor_id' => null]);

            return to_route('families.show', $family)->with('success', 'تم الغاء ارتباط المشرف بالاسرة بنجاح');
        } catch (Exception $e) {
            $this->log->error('Unlink supervisor with family id=' . $family, ['exception' =>  $e->getMessage()]);
            return $e->getMessage();
        }
    }


    public function socialServices($family)
    {
        try {
            return view('families.socialServices', [
                'family' => $this->family->findOrFail($family)->loadMissing(['assistances', 'projects', 'homeServices'])
            ]);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function categoriesReport()
    {
        return view('reports.categoriesReport', $this->familyService->categoriesReport());
    }

    public function relatedMartyrs(int $family)
    {
        $martyrs = $this->martyr->where('family_id', $family)->get();
        $family  = $this->family->findOrFail($family)->loadMissing(['martyr', 'address']);

        return view('families.relatedMartyrs', compact('martyrs', 'family'));
    }
}

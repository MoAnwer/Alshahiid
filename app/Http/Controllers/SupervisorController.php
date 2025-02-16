<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\SupervisorRequest;
use App\Models\{Supervisor, Family};
use Illuminate\Support\Facades\{Log, DB};

class SupervisorController extends Controller
{
    protected $log;
    protected Family $family;
    protected Supervisor $supervisor;

    public function __construct()
    {
        $this->family = new Family;
        $this->supervisor = new Supervisor;
        $this->log = Log::stack(['stack' => Log::build(['driver' => 'single', 'path' => storage_path('logs/alshahiid.log')]) ]);
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

        $query = DB::table('supervisors')
                ->leftJoin('families', 'families.supervisor_id', 'supervisors.id')
                ->selectRaw('COUNT(families.id) as families_count, supervisors.id as id, supervisors.name as name,  supervisors.phone as phone')
                ->groupBy(['supervisors.name',  'supervisors.phone', 'id']);


        if($request->query('search') == 'name') {
            $query->where('supervisors.name', 'LIKE', "%$needel%");
        }


        if($request->query('search') == 'phone') {
            $query->where('supervisors.phone', $needel);
        }

        $supervisors = $query->paginate(10);


        return view('supervisors.supervisors', compact('supervisors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supervisors.createSupervisor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupervisorRequest $request)
    {
        $data = $request->validated();

        try {
            $this->supervisor->create($data);
            return back()->with('success', 'تم اضافة المشرف بنجاح');
        } catch (Exception $e) {
            $this->log->error('store supervisor', ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('supervisors.supervisorProfile', ['supervisor' =>$this->supervisor->findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('supervisors.editSupervisor', ['supervisor' => $this->supervisor->findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupervisorRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $this->supervisor->findOrFail($id)->update($data);
            return back()->with('success', 'تم تعديل المشرف بنجاح');
        } catch (Exception $e) {
            $this->log->error('update supervisor id='.$id, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }


    public function delete($id) 
    {
        return view('supervisors.delete', ['supervisor' => $this->supervisor->findOrFail($id)]);
    }

    public function destroy($id)
    {
        try {
            $supervisor = $this->supervisor->findOrFail($id);
            $supervisor->families()->update(['supervisor_id' => null]);
            $supervisor->delete();
            return to_route('supervisors.index')->with('success', 'تم حذف بيانات المشرف بنجاح');

        } catch (Exception $e) {
            $this->log->error('Destroy supervisor id='.$id, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
        
    }

    /**
     * families of specific supervisor
     */

    public function families(int $supervisor)
    {
        $request = request();

        $needel = trim($request->query('needel'));

        $query = DB::table('families')
                ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                ->join('supervisors', 'supervisors.id', '=', 'families.supervisor_id')
                ->join('martyrs', 'martyrs.id', '=', 'families.martyr_id')
                ->selectRaw(
                    'supervisors.name as name,
                    martyrs.name as martyr_name,
                    families.family_size as family_size,
                    families.id as family_id,
                    families.category as category,
                    supervisors.phone as phone,
                    addresses.sector as sector,
                    addresses.locality as locality,
                    COUNT(families.id) as families_count'
                )->groupBy([
                        'name', 'family_size', 'category', 'phone', 'sector', 'locality', 'martyr_name', 'families.id'
                ]);


        if($request->query('search') == 'name') {
            $query->where('martyrs.name', 'LIKE', "%$needel%");
        }

        if($request->query('search') == 'force') {
            $query->where('martyrs.force', 'LIKE', "%$needel%");
        }

        if($request->query('search') == 'militarism_number') {
            $query->where('martyrs.militarism_number',  $needel);
        }

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        if (!empty($request->query('category')) && $request->query('category') != 'all') {
            $query->where('families.category', $request->query('category'));
        } 

        if($request->query('search') == 'phone') {
            $query->where('phone', $needel);
        }

        $families = $query->paginate();
        
        $supervisorName = $this->supervisor->findOrFail($supervisor);
    
        return view('supervisors.familiesList', compact('families', 'supervisorName'));
    }

    public function addFamilies()
    {
        return view('supervisors.addFamilies');
    }
}

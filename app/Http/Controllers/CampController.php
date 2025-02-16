<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Camp;
use App\Http\Requests\CampRequest;
use Illuminate\Support\Facades\{Log, DB};

class CampController extends Controller
{

    protected $log;
    protected Camp $camp;

    public function __construct()
    {
        $this->camp = new Camp;
        $this->log  = Log::stack(['stack' => Log::build(['driver' => 'single', 'path' => storage_path('logs/alshahiid.log')]) ]);
    }

    public function index()
    {

        $request = request();

        $camp_name = trim(htmlentities($request->query('name')));

        $query = DB::table('camps')
                ->select('id','budget', 'name', 'budget_out_of_org', 'budget_from_org', 'notes', 'status', 'start_at', 'end_at', 'sector', 'locality');

        if (!empty($camp_name)) {
            $query->where('name', 'LIKE', "%$camp_name%");
        }

        if (!empty($request->query('status')) && $request->query('status') != 'all') {
            $query->where('status', $request->query('status'));
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('sector', $request->query('sector'));
        }

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('locality', $request->query('locality'));
        }

        if (!empty($request->query('year')) && $request->query('year') != '') {
            $query->whereYear('created_at', $request->query('year'));
        }

        if (!empty($request->query('month')) && $request->query('month') != '') {
            $query->whereMonth('created_at', $request->query('month'));
        }

        $camps = $query->latest('id')->paginate();

        return view('tazkiia.camps.index', ['camps' => $camps]);
    }


    public function create()
    {
        return view('tazkiia.camps.create');
    }

    public function store(CampRequest $request)
    {
        $data = $request->validated();

        try {
            $this->camp->create($data);

            return to_route('tazkiia.camps.index')->with('success', 'تم اضافة المعسكر بنجاح');
        } catch(Exception $e) {
            $this->log->error('Store camp', ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        return view('tazkiia.camps.edit', ['camp' => $this->camp->findOrFail($id)]);
    }


    public function update(CampRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $this->camp->findOrFail($id)->update($data);
            return back()->with('success', 'تم التعديل على المعسكر بنجاح');
        } catch (Exception $e) {
            $this->log->error('Updating camp id='.$id , ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
       return view('tazkiia.camps.delete', ['camp' => $this->camp->findOrFail($id)]);
    }

    public function destroy($id)
    {
        $this->camp->findOrFail($id)->delete();
        return to_route('tazkiia.camps.index')->with('success', "تم حذف المعسكر بنجاح");
    }
}

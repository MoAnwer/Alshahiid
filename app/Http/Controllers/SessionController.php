<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Session;
use App\Http\Requests\SessionRequest;
use Illuminate\Support\Facades\{Log, DB};

class SessionController extends Controller
{

    protected Session $session;
    protected $log;

    public function __construct()
    {
        $this->session = new Session;
        $this->log  = Log::stack(['stack' => Log::build(['driver' => 'single', 'path' => storage_path('logs/alshahiid.log')]) ]);
    }

    public function index()
    {
        $request = request();

        $session_name = trim(htmlentities($request->query('name')));

        $query = DB::table('sessions')
                ->select('id','budget', 'name', 'budget_out_of_org', 'budget_from_org', 'notes', 'status',  'sector', 'locality', 'date');

        if (!empty($session_name)) {
            $query->where('name', 'LIKE', "%$session_name%");
        }

        if (!empty($request->query('date'))) {
            $query->where('date', $request->query('date'));
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



        return view('tazkiia.sessions.index', ['sessions' => $query->latest('id')->paginate(10)]);
    }

    public function create()
    {
        return view('tazkiia.sessions.create');
    }

    public function store(SessionRequest $request)
    {
        $data = $request->validated();
        try {
            $this->session->create($data);
            return back()->with('success', 'تم اضافة الحلقة بنجاح');
        } catch (Exception $e) {
            $this->log->error('Storing session ', ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }


    public function edit(int $session)
    {
        return view('tazkiia.sessions.edit', ['session' => $this->session->findOrFail($session)]);
    }

    public function update(SessionRequest $request, int $session)
    {
        $data = $request->validated();

        try {

            $this->session->findOrFail($session)->update($data);
            return back()->with('success', 'تم التعديل بنجاح على الحلقة');
            
        } catch (Exception $e) {
            $this->log->error('update session id='.$session, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }


    public function delete($session)
    {
        return view('tazkiia.sessions.delete', ['session' => $this->session->findOrFail($session)]);
    }

    public function destroy(int $session)
    {
        try {
            $session = $this->session->findOrFail($session);
            $name = $session->name;
            $session->delete();

            return to_route('tazkiia.sessions.index')->with('success', 'تم حذف حلقة ' . $name . ' بنجاح');
        } catch (Exception $e) {
            $this->log->error('Destroy session id='.$session, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }
}

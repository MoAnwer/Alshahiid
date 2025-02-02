<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Session;
use App\Http\Requests\SessionRequest;

class SessionController extends Controller
{

    public function index()
    {
        return view('tazkiia.sessions.index', ['sessions' => Session::orderByDESC('id')->paginate(10)]);
    }

    public function create()
    {
        return view('tazkiia.sessions.create');
    }

    public function store(SessionRequest $request)
    {
        $data = $request->validated();
        try {
            Session::create($data);
            return back()->with('success', 'تم اضافة الحلقة بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function edit(int $session)
    {
        return view('tazkiia.sessions.edit', ['session' => Session::findOrFail($session)]);
    }

    public function update(SessionRequest $request, int $session)
    {
        $data = $request->validated();

        try {

            Session::findOrFail($session)->update($data);
            return back()->with('success', 'تم التعديل بنجاح على الحلقة');
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function delete($session)
    {
        return view('tazkiia.sessions.delete', ['session' => Session::findOrFail($session)]);
    }

    public function destroy(int $session)
    {
        try {
            $session = Session::findOrFail($session);
            $name = $session->name;
            $session->delete();

            return to_route('tazkiia.sessions.index')->with('success', 'تم حذف حلقة ' . $name . ' بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}

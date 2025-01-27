<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\SupervisorRequest;
use App\Models\Supervisor;

class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supervisors.supervisors', ['supervisors' => Supervisor::orderByDESC('id')->paginate()]);
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
            Supervisor::create($data);
            return back()->with('success', 'تم اضافة المشرف بنجاح');
        } catch (Exception $e) {
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
        return view('supervisors.supervisorProfile', ['supervisor' => Supervisor::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('supervisors.editSupervisor', ['supervisor' => Supervisor::findOrFail($id)]);
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
            Supervisor::findOrFail($id)->update($data);
            return back()->with('success', 'تم تعديل المشرف بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function delete($id) 
    {
        return view('supervisors.delete', ['supervisor' => Supervisor::findOrFail($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $supervisor = Supervisor::findOrFail($id);
            $supervisor->delete();

        } catch (Exception $e) {
            return $e->getMessage();
        }
        return to_route('supervisors.index')->with('success', 'تم حذف بيانات المشرف بنجاح');
    }

    public function families(int $supervisor)
    {
        $supervisor = Supervisor::findOrFail($supervisor)->loadMissing('families');
        return view('supervisors.familiesList', compact('supervisor'));
    }

    public function addFamilies()
    {
        return view('supervisors.addFamilies');
    }
}

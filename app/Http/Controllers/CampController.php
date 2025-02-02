<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Camp;
use App\Http\Requests\CampRequest;

class CampController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tazkiia.camps.index', ['camps' => Camp::orderByDESC('id')->paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tazkiia.camps.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampRequest $request)
    {
        $data = $request->validated();

        try {
            Camp::create($data);

            return to_route('tazkiia.camps.index')->with('success', 'تم اضافة المعسكر بنجاح');
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('tazkiia.camps.edit', ['camp' => Camp::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CampRequest $request, $id)
    {
        $data = $request->validated();

        try {
            Camp::findOrFail($id)->update($data);
            return back()->with('success', 'تم التعديل على المعسكر بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
       return view('tazkiia.camps.delete', ['camp' => Camp::findOrFail($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Camp::findOrFail($id)->delete();
        return to_route('tazkiia.camps.index')->with('success', "تم حذف المعسكر بنجاح");
    }
}

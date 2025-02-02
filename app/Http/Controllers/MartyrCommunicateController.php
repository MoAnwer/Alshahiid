<?php

namespace App\Http\Controllers;

use App\Models\Communicate;
use App\Models\Family;
use Illuminate\Http\Request;

class MartyrCommunicateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tazkiia.communicate.index', ['coms' => Communicate::orderByDESC('id')->paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $family)
    {
        return view('tazkiia.communicate.create', ['family' => Family::findOrFail($family)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $family)
    {
        $data = $request->validate([
            'phone' => 'required|string',
            'budget'    => 'required|numeric',
            'budget_from_org' => 'nullable|numeric',
            'budget_out_of_org' => 'nullable|numeric',
            'status'    => 'required',
            'isCom' => 'required',
            'notes' => 'nullable|string'
        ], [
            'phone' => 'رقم الهاتف مطلوب',
        ]);

        try {
            $family = Family::findOrFail($family);
            $family->communicate()->create($data);

            return to_route('families.show', $family->id)->with('success', 'تم  اضافة بيانات التواصل مع اسرة الشهيد  ' . $family->martyr->name . ' بنجاح');
        } catch (Exception $e) {
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
        return view('tazkiia.communicate.edit', ['com' => Communicate::findOrFail($id)->loadMissing('family')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'phone' => 'required|string',
            'budget'    => 'required|numeric',
            'budget_from_org' => 'nullable|numeric',
            'budget_out_of_org' => 'nullable|numeric',
            'status'    => 'required',
            'isCom' => 'required',
            'notes' => 'nullable|string'
        ], [
            'phone' => 'رقم الهاتف مطلوب',
            'buget' => 'المبلغ مطلوب'
        ]);

        try {
            Communicate::findOrFail($id)->update($data);
            return back()->with('success', 'تم  التعديل  على بيانات التواصل مع اسرة الشهيد بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {
        return view('tazkiia.communicate.delete', ['com' => Communicate::findOrFail($id)->loadMissing('family')]);
    }

    public function destroy($id)
    {
        Communicate::findOrFail($id)->delete($id);
        return to_route('tazkiia.communicate.index')->with('success', 'تم حذف بيانات التواصل مع اسرة الشهيد بنجاح');
    }
}

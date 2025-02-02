<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Hag;
use App\Models\FamilyMember;
use Illuminate\Http\Request;

class HagController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $member)
    {
        try {
            $familyMember = FamilyMember::findOrFail($member);
            return view('tazkiia.hagAndOmmrah.create', compact('familyMember'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(Request $request, $member)
    {
        $data = $request->validate([
            'status' => 'required',
            'type'  => 'required',
            'budget'    => 'required',
            'budget_from_org' => 'nullable|numeric',
            'budget_out_of_org' => 'nullable|numeric',
        ], [
            'budget'    => 'المبلغ مطلوب'
        ]);

        try {
            $familyMember = FamilyMember::findOrFail($member);
            $familyMember->hags()->create($data);
            return to_route('familyMembers.show', $familyMember->id)->with('success', 'تم اضافة خدمة ' . $data['type'] . ' بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hag  $hag
     * @return \Illuminate\Http\Response
     */
    public function edit(int $hag)
    {
        return view('tazkiia.hagAndOmmrah.edit', ['hag' => Hag::findOrFail($hag)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hag  $hag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $hag)
    {
        $data = $request->validate([
            'status' => 'required',
            'type'  => 'required',
            'budget'    => 'required',
            'budget_from_org' => 'nullable|numeric',
            'budget_out_of_org' => 'nullable|numeric',
        ], [
            'budget'    => 'المبلغ مطلوب'
        ]);

        try {
            Hag::findOrFail($hag)->update($data);
            return back()->with('success', 'تم تعديل خدمة ' . $data['type'] . ' بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function delete($id) 
    {
        return view('tazkiia.hagAndOmmrah.delete', ['hag' => Hag::findOrFail($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hag  $hag
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $hag)
    {
        $hag = Hag::findOrFail($hag);
        $type  = $hag->type;
        $memberId = $hag->familyMember->id;
        $hag->delete();

        return to_route('familyMembers.show', $memberId)->with('success', 'تم حذف خدمة حج و عمرة بنجاح ');
    }
}

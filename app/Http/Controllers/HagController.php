<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Hag;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Log, DB};

class HagController extends Controller
{

    protected $log;
    protected Hag $hag;
    protected FamilyMember $member;

    public function __construct() 
    {
        $this->member = new FamilyMember;
        $this->hag = new Hag;
        $this->log  = Log::stack(['stack' => Log::build(['driver' => 'single', 'path' => storage_path('logs/alshahiid.log')]) ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $member)
    {
        try {
            $familyMember = $this->member->findOrFail($member);
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
            $familyMember = $this->member->findOrFail($member);
            $familyMember->hags()->create($data);
            
            return to_route('familyMembers.show', $familyMember->id)->with('success', 'تم اضافة خدمة ' . $data['type'] . ' بنجاح');
        } catch (Exception $e) {
            $this->log->error('store hag', ['exception' => $e->getMessage()]);
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
        return view('tazkiia.hagAndOmmrah.edit', ['hag' => $this->hag->findOrFail($hag)]);
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
            $this->hag->findOrFail($hag)->update($data);
            return back()->with('success', 'تم تعديل خدمة ' . $data['type'] . ' بنجاح');
        } catch (Exception $e) {
            $this->log->error('update hag', ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }


    public function delete($id) 
    {
        return view('tazkiia.hagAndOmmrah.delete', ['hag' => $this->hag->findOrFail($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hag  $hag
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $hag)
    {
        $hag = $this->hag->findOrFail($hag);
        $memberId = $hag->familyMember->id;
        $hag->delete();
        return to_route('familyMembers.show', $memberId)->with('success', 'تم حذف خدمة حج و عمرة بنجاح ');
    }
}

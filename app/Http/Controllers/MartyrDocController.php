<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Martyr;
use App\Models\MartyrDoc;
use Illuminate\Http\Request;

class MartyrDocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return view('tazkiia.martyrDocs.index', ['martyr' => Martyr::findOrFail($id)->loadMissing('martyrDoc')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('tazkiia.martyrDocs.create', ['martyr' => Martyr::findOrFail($id)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $martyr)
    {
        if ($request->hasFile('storage_path')) {
            $data = $request->validate([
                'budget' => 'nullable|numeric',
                'budget_from_org' => 'nullable|numeric',
                'budget_out_of_org' => 'nullable|numeric',
                'storage_path' => 'nullable',
                'status'    => 'in:مطلوب,منفذ',
                'notes' => 'nullable|string'
            ]);

            try {

                $document = str()->orderedUuid() . '.' . $request->file('storage_path')->getClientOriginalExtension();
        
                $request->file('storage_path')->move(public_path('uploads/documents'), $document);

                $data['storage_path'] = $document;

                Martyr::findOrFail($martyr)->martyrDoc()->create($data);

                return to_route('tazkiia.martyrDocs.index', $martyr)->with('success', 'تم اضافة سيرة ذاتية بنجاح');

            } catch (Exception $e) {
                return $e->getMessage();
            }

        } else {

            
            $data = $request->validate([
                'budget' => 'nullable|numeric',
                'budget_from_org' => 'nullable|numeric',
                'budget_out_of_org' => 'nullable|numeric',
                'status'    => 'in:مطلوب,منفذ',
                'notes' => 'nullable|string'
            ]);


            try {

                Martyr::findOrFail($martyr)->martyrDoc()->create($data);

                return to_route('tazkiia.martyrDocs.index', $martyr)->with('success', 'تم اضافة سيرة ذاتية بنجاح');

            } catch (Exception $e) {
                return $e->getMessage();
            }

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('tazkiia.martyrDocs.edit', ['doc' => MartyrDoc::findOrFail($id)->loadMissing('martyr')]);
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
        try {
            $document = MartyrDoc::findOrFail($id);

            $data = [];

            if ($request->hasFile('storage_path')) {

                $data = $request->validate([
                    'budget' => 'nullable|numeric',
                    'budget_from_org' => 'nullable|numeric',
                    'budget_out_of_org' => 'nullable|numeric',
                    'storage_path' => 'nullable',
                    'status'    => 'in:مطلوب,منفذ',
                    'notes' => 'nullable|string'
                ]);

                @unlink(public_path('uploads/documents/'.$document->storage_path));

                $documentFile = str()->orderedUuid() . '.' . $request->file('storage_path')->getClientOriginalExtension();
    
                $request->file('storage_path')->move(public_path('uploads/documents'), $documentFile);

                $data['storage_path'] = $documentFile;

                $document->update($data);

                return to_route('tazkiia.martyrDocs.index', $document->martyr)->with('success', 'تم تعديل السيرة ذاتية بنجاح');

            } else {
                $data = $request->validate([
                    'budget' => 'nullable|numeric',
                    'budget_from_org' => 'nullable|numeric',
                    'budget_out_of_org' => 'nullable|numeric',
                    'status'    => 'in:مطلوب,منفذ',
                    'notes' => 'nullable|string'
                ]);


                $document->update($data);

                return to_route('tazkiia.martyrDocs.index', $document->martyr)->with('success', 'تم تعديل السيرة ذاتية بنجاح');
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        return view('tazkiia.martyrDocs.delete', ['doc' => MartyrDoc::findOrFail($id)]);
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
            $doc = MartyrDoc::findOrFail($id);
            $martyrName = $doc->martyr->name;
            $familyId = $doc->martyr->family->id;
            $doc->delete();
            @unlink(public_path('uploads/documents/'.$doc->storage_path));
            return to_route('families.show', $familyId)->with('success', 'تم حذف السيرة الشخصية للشهيد ' . $martyrName);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}

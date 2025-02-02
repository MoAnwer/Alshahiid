<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\FamilyMember;
use App\Models\FamilyMemberDocument;

class FamilyMemberDocumentController extends Controller
{
    protected string $docsDir = 'uploads/members_documents';
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $member)
    {
        return view('familyMemberDocuments.create', ['member' => FamilyMember::findOrFail($member)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $member)
    {
        $data = $request->validate([
            'type'  => 'required',
            'storage_path'  => 'required',
            'notes' => 'nullable|string'
        ]);

        try {

            $document = str()->orderedUuid() . '.' . $request->file('storage_path')->getClientOriginalExtension();
    
            $request->file('storage_path')->move(public_path($this->docsDir), $document);

            $data['storage_path'] = $document;
            
            FamilyMember::findOrFail($member)->documents()->create($data);

            return to_route('familyMembers.show', $member)->with('success', 'تم اضافة الوثيقة بنجاح');

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
        return view('familyMemberDocuments.edit', ['document' => FamilyMemberDocument::findOrFail($id)]);
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
            $document = FamilyMemberDocument::findOrFail($id);

            $data = [];

            if ($request->hasFile('storage_path')) {

                $data = $request->validate([
                    'storage_path' => 'required',
                    'type'  =>  'required|string',
                    'notes' => 'nullable|string'
                ]);

                @unlink(public_path($this->docsDir.'/'.$document->storage_path));

                $documentFile = str()->orderedUuid() . '.' . $request->file('storage_path')->getClientOriginalExtension();
    
                $request->file('storage_path')->move(public_path($this->docsDir), $documentFile);

                $data['storage_path'] = $documentFile;

                $document->update($data);

                return to_route('familyMembers.show', $document->familyMember->id)->with('success','تم تعديل الوثيقة بنجاح');

            } else {
                $data = $request->validate([
                    'type'  =>  'required|string',
                    'notes' => 'nullable|string'
                ]);

                $document->update($data);

                return to_route('familyMembers.show', $document->familyMember->id)->with('success', 'تم تعديل الوثيقة بنجاح');
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    
    public function delete($id) 
    {
         return view('familyMemberDocuments.delete', ['document' => FamilyMemberDocument::findOrFail($id)]);
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
            $document = FamilyMemberDocument::findOrFail($id);
            $memberId = $document->family_member_id;
            @unlink(public_path($this->docsDir.'/'.$document->storage_path));
            $document->delete();
            return to_route('familyMembers.show', $memberId)->with('success', 'تم حذف الوثيقة بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}

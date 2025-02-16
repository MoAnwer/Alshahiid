<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\FamilyMember;
use App\Models\FamilyMemberDocument;
use Illuminate\Support\Facades\Log;

class FamilyMemberDocumentController extends Controller
{
    protected $log;
    protected FamilyMember $member;
    protected FamilyMemberDocument $memberDocument;
    protected string $docsDir = 'uploads/members_documents';

    public function __construct()
    {
        $this->member   = new FamilyMember;
        $this->memberDocument = new FamilyMemberDocument;
        $this->log  = Log::stack(['stack' => Log::build(['driver' => 'single', 'path' => storage_path('logs/alshahiid.log')]) ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $member)
    {
        return view('familyMemberDocuments.create', ['member' => $this->member->findOrFail($member)]);
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
        ],  [
            'storage_path'  => 'ملف الوثيقة مطلوب'
        ]);

        try {

            $document = str()->orderedUuid() . '.' . $request->file('storage_path')->getClientOriginalExtension();
    
            $request->file('storage_path')->move(public_path($this->docsDir), $document);

            $data['storage_path'] = $document;
            
            $this->member->findOrFail($member)->documents()->create($data);

            return to_route('familyMembers.show', $member)->with('success', 'تم اضافة الوثيقة بنجاح');

        } catch (Exception $e) {
            $this->log->error('Storing document to family member id='.$member, ['exception' => $e->getMessage()]);
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
        return view('familyMemberDocuments.edit', ['document' => $this->memberDocument->findOrFail($id)]);
    }

    public function update(Request $request, $id) 
    {
        
        try {
            $document = $this->memberDocument->findOrFail($id);

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
            $this->log->error('Updating family member document  id='.$id, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }

    }

    
    public function delete($id) 
    {
         return view('familyMemberDocuments.delete', ['document' => $this->memberDocument->findOrFail($id)]);
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
            $document = $this->memberDocument->findOrFail($id);
            $memberId = $document->family_member_id;
            @unlink(public_path($this->docsDir.'/'.$document->storage_path));
            $document->delete();
            return to_route('familyMembers.show', $memberId)->with('success', 'تم حذف الوثيقة بنجاح');
        } catch (Exception $e) {
            $this->log->error('destroy family member document  id='.$id, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }
}

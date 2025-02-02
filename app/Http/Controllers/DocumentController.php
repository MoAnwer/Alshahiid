<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Family;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Requests\DocumentRequest;

class DocumentController extends Controller
{
    
    public function create(int $familyId)
    {   
        return view('documents.create', [
            'family'    => Family::findOrFail($familyId)
        ]);
    }

    public function store(DocumentRequest $request, $familyId)
    {

        $data = $request->validated();

        try {

            $document = str()->orderedUuid() . '.' . $request->file('storage_path')->getClientOriginalExtension();
    
            $request->file('storage_path')->move(public_path('uploads/documents'), $document);

            $data['storage_path'] = $document;
            
            Family::findOrFail($familyId)->documents()->create($data);

            return to_route('documents.show', $familyId)->with('تم اضافة الخطاب بنجاح');

        } catch (Exception $e) {
            return $e->getMessage();
        }

        return to_route('documents.show', $familyId)->with('success', 'تم اضافة الخطاب بنجاح');
    }

    public function familyDocuments(int $familyId) 
    {
        return view('documents.familyDocuments', [
            'family' => Family::findOrFail($familyId)->loadMissing(['martyr', 'documents'])
        ]);
    }

    public function edit($id)
    {
        return view('documents.edit', [
            'document'  => Document::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id) 
    {
        
        try {
            $document = Document::findOrFail($id);

            $data = [];

            if ($request->hasFile('storage_path')) {

                $data = $request->validate([
                    'storage_path' => 'required',
                    'type'  =>  'required|string',
                    'notes' => 'nullable|string'
                ]);

                @unlink(public_path('uploads/documents/'.$document->storage_path));

                $documentFile = str()->orderedUuid() . '.' . $request->file('storage_path')->getClientOriginalExtension();
    
                $request->file('storage_path')->move(public_path('uploads/documents'), $documentFile);

                $data['storage_path'] = $documentFile;

                $document->update($data);

                return to_route('documents.show', $document->family->id)->with('success','تم تعديل الخطاب بنجاح');

            } else {
                $data = $request->validate([
                    'type'  =>  'required|string',
                    'notes' => 'nullable|string'
                ]);

                $document->update($data);

                return to_route('documents.show', $document->family->id)->with('success', 'تم تعديل الخطاب بنجاح');
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function delete($id) {
        return view('documents.delete', ['document' => Document::findOrFail($id)]);
    }

    public function destroy($id) 
    {
        try {
            $document = Document::findOrFail($id);

            @unlink(public_path('uploads/documents/'.$document->storage_path));

            $document->delete();

            return to_route('documents.show', $document->family->id)->with('success', 'تم حذف الخطاب بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}

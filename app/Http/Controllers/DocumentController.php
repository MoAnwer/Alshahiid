<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Family;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Requests\DocumentRequest;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    protected $log;
    protected Family $family;
    protected Document $document;
    protected string $docsDir;

    public function __construct()
    {
        $this->family   = new Family;
        $this->document = new Document;
        $this->docsDir  = 'uploads/documents';
        $this->log  = Log::stack(['stack' => Log::build(['driver' => 'single', 'path' => storage_path('logs/alshahiid.log')]) ]);
    }

    
    public function create(int $familyId)
    {   
        return view('documents.create', ['family'  => $this->family->findOrFail($familyId)]);
    }

    public function store(DocumentRequest $request, $familyId)
    {

        $data = $request->validated();

        try {

            $document = str()->orderedUuid() . '.' . $request->file('storage_path')->getClientOriginalExtension();
    
            $request->file('storage_path')->move(public_path($this->docsDir), $document);

            $data['storage_path'] = $document;
            
            $this->family->findOrFail($familyId)->documents()->create($data);

            return to_route('documents.show', $familyId)->with('تم اضافة الخطاب بنجاح');

        } catch (Exception $e) {
            $this->log->error('Store family document familyId='.$familyId, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }

        return to_route('documents.show', $familyId)->with('success', 'تم اضافة الخطاب بنجاح');
    }

    public function familyDocuments(int $familyId) 
    {
        return view('documents.familyDocuments', [
            'family' => $this->family->findOrFail($familyId)->loadMissing(['martyr', 'documents'])
        ]);
    }

    public function edit($id)
    {
        return view('documents.edit', [
            'document'  => $this->document->findOrFail($id)
        ]);
    }

    public function update(Request $request, $id) 
    {
        
        try {
            $document = $this->document->findOrFail($id);

            $data = [];

            if ($request->hasFile('storage_path')) {

                $data = $request->validate([
                    'storage_path' => 'required',
                    'type'  =>  'required|string',
                    'notes' => 'nullable|string'
                ]);

                @unlink(public_path('uploads/documents/'.$document->storage_path));

                $documentFile = str()->orderedUuid() . '.' . $request->file('storage_path')->getClientOriginalExtension();
    
                $request->file('storage_path')->move(public_path($this->docsDir), $documentFile);

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
            $this->log->error('Updating document id='.$id, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }

    }

    public function delete($id) {
        return view('documents.delete', ['document' => $this->document->findOrFail($id)]);
    }

    public function destroy($id) 
    {
        try {
            $document = $this->document->findOrFail($id);

            @unlink(public_path($this->docsDir.'/'.$document->storage_path));

            $document->delete();

            return to_route('documents.show', $document->family->id)->with('success', 'تم حذف الخطاب بنجاح');
        } catch (Exception $e) {
            $this->log->error('Destroy document id='.$id, ['exception' => $e->getMessage()]);
            return $e->getMessage();
        }
    }

}

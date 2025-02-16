<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Family;
use App\Services\AddressService;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    protected $log;
    protected Family $family;
    protected Address $address;
    protected AddressService $addressService;

    public function __construct() 
    {
        $this->family   = new Family;
        $this->address  = new Address;
        $this->addressService  = new AddressService;
        $this->log      = Log::stack(['stack' => Log::build(['driver' => 'single', 'path' => storage_path('logs/alshahiid.log')]) ]);
    }

    public function create(int $family) 
    {
        return view('address.create', ['family' => $this->family->findOrFail($family)]);
    }
    

    public function store(Request $request, int $family) 
    {
        $data = $request->validate([
            'sector'       => 'required',
            'locality'     => 'required',
            'type'         => 'required',
            'neighborhood' => 'string|required'
        ], [
            'neighborhood' => 'اسم الحي مطلوب'
        ]);

        try {

            $this->family->findOrFail($family)->addresses()->create($data);

            return back()->with('success', 'تم انشاء السكن بنجاح');

        } catch(Exception $e) {
            $this->log->error('Storing address to family id='.$family, ['exception' =>  $e->getMessage()]);
            return $e->getMessage();

        } 
    }

    public function edit(int $id) 
    {
		try {
			return view('address.edit', ['address' => $this->address->findOrFail($id)]);
		} catch (Exception $e) {
            $this->log->error('Edit address id='.$id, ['exception' =>  $e->getMessage()]);
            return $e->getMessage();
        }
    }

    public function update(Request $request, int $id) 
    {

        $data = $request->validate([
            'sector'       => 'required',
            'locality'     => 'required',
            'type'         => 'required',
            'neighborhood' => 'string|required'
        ], [
            'neighborhood' => 'اسم الحي مطلوب'
        ]);
		
        try {

            $this->address->findOrFail($id)->update($data);

            return back()->with('success', 'تم تعديل بيانات السكن بنجاح');

        } catch(Exception $e) {
            $this->log->error('Update address id='.$id, ['exception' =>  $e->getMessage()]);
            return $e->getMessage();

        }
        
    } 

    public function delete(int $id) 
    {
        try {
            return view('address.delete', ['address' => $this->address->findOrFail($id)]);
        } catch (Exception $e) {
            $this->log->error('Delete address id='.$id, ['exception' =>  $e->getMessage()]);
            return $e->getMessage();
        }
    }

    public function destroy(int $id)  
    {
        try {

            $address  = $this->address->findOrFail($id);
            $familyId = $address->family->id;
            $address->delete();

            return to_route('families.show', $familyId)->with('success', 'تم حذف بيانات السكن بنجاح');

        } catch (Exception $e) {
            $this->log->error('Destroy address id='.$id, ['exception' =>  $e->getMessage()]);
            return $e->getMessage();
        }
    }

    public function report()
    {
        return view('reports.address', $this->addressService->report());
    }
}

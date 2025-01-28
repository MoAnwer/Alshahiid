<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Family;
use App\Models\Supervisor;
use App\Models\Martyr;
use Illuminate\Support\Facades\DB;

class FamilyController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $martyr)
    {
        return view('families.create', ['martyr' => 
            Martyr::findOrFail($martyr)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $martyr)
    {
        $family = $request->validate(['category' => 'required', 'family_size' => 'required'], [
            'family_size'   => 'الرجاء ادخال عدد افراد الاسرة'
        ]);

        $address  = $request->validate([
            'sector'        => 'required',
            'locality'      => 'required',
            'type'          => 'required',
            'neighborhood'  => 'required'
        ], [
            'neighborhood'  => 'اسم الحي مطلوب'
        ]);

        try {

            $martyr = Martyr::findOrFail($martyr);
            $family = $martyr->family()->create($family);
            $family->address()->create($address);

            return to_route('families.show', $family->id)->with('success', 'تمت اضافة بيانات الاسرة بنجاح ✅👍🏼');
        } catch (Exception $e) {

            return abort(404, $e->getMessage());
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
        $family = Family::findOrFail($id);
        return view('families.martyrFamily', compact('family'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $family = Family::findOrFail($id);
        return view('families.edit', compact('family'));
    }

    public function update(Request $request, $id)
    {
        $familyData = $request->validate(['category' => 'required', 'family_size' => 'required'], [
            'family_size'   => 'الرجاء ادخال عدد افراد الاسرة'
        ]);

        try {

            $family = Family::findOrFail($id);
            $family->update($familyData);

            return to_route('families.show', $family->id)->with('success', 'تمت اضافة بيانات الاسرة بنجاح ✅👍🏼');
        } catch (Exception $e) {
            return $e->getMessage();
            return abort(404, $e->getMessage());
        }
    }


	public function delete(int $id) 
	{
		$family = Family::findOrFail($id);
        return view('families.delete', ['family' => $family]);
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
            $family = Family::findOrFail($id);
            $martyrId = $family->martyr->id;
            $family->addresses()->delete();
            $family->delete();

            return to_route('martyrs.index', $martyrId)->with('success', 'تم حذف الاسرة بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function createSupervisor($family) 
    {
        return view('families.createSupervisor', [
            'family'       => Family::findOrFail($family), 
            'supervisors'  => Supervisor::all()
        ]);
    }

    public function storeSupervisor(Request $request, int $family)
    {
        $data = $request->validate([
            'supervisor_id'    => 'required|exists:supervisors,id'
        ]);

        try {

            Family::findOrFail($family)->update($data);

            return to_route('families.show', $family)->with('success', 'تم إضافة المشرف بنجاح');

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function editSupervisor(int $family)
    {
        return view('families.editSupervisor', [
            'family'        => Family::findOrFail($family)->loadMissing(['martyr','supervisor']),
            'supervisors'   => Supervisor::all()
        ]);
    }


    public function deleteSupervisor(int $family)
    {
        return view('families.deleteSupervisor', [
            'family' => Family::findOrFail($family)->loadMissing(['martyr','supervisor'])
        ]);

        return to_route('families.show', $family)->with('success', 'تم تعديل المشرف بنجاح');
    }

    public function destroySupervisor(int $family)
    {
        try {
            Family::findOrFail($family)->update(['supervisor_id' => null]);
            return to_route('families.show', $family)->with('success', 'تم الغاء ارتباط المشرف بالاسرة بنجاح');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function socialServices($family) 
    {
        return view('families.socialServices', ['family' => Family::findOrFail($family)]);
    }

    public function monthlyBails($family)
    {
        return view('families.bails',  ['family' => Family::findOrFail($family)]);
    }

    public function categoriesReport() 
    {
        $request = request();

        $report = null;

        if(($sector = $request->query('sector')) && ($locality = $request->query('locality'))) {
            $report = collect(DB::select('
                            SELECT 
                                f.category, 
                                COUNT(f.id) as count,
                                a.sector,
                                a.locality 
                            FROM
                                families f
                            INNER JOIN
                                addresses  a
                            ON
                                a.family_id = f.id 
                            WHERE 
                                a.sector = ?
                            AND 
                                a.locality = ?
                            GROUP BY
                                f.category, a.sector, a.locality
                    ', [$sector, $locality]
            ));
        } else {
            $report = Family::selectRaw('category, count(id) as count')->groupBy('category')->get();
        }
        
        $report = $report->groupBy('category');

        
        $totalCount = Family::count();
        $report = collect([
            'أ'     => $report->get('أرملة و ابناء', []),
            'ب'     => $report->get('أب و أم و أخوان و أخوات', []),
            'ج'     => $report->get('أخوات', []),
            'د'     => $report->get('مكتفية', []),
        ]);

        return view('reports.categoriesReport', compact('report', 'totalCount'));
    }    
    
}
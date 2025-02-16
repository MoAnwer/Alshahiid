<?php

namespace App\Services;

use App\Models\Family;
use Illuminate\Support\Facades\DB;

class FamilyService 
{

  /**
   * Family categories report 
   * @return array
   */

  public function categoriesReport() 
  {
        $request = request();

        $query = DB::table('families')
                ->join('addresses', 'addresses.family_id', 'families.id')
                ->selectRaw('families.category as category, COUNT(families.id) as count')
                ->groupBy('families.category');


        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector', 'families.category']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->selectRaw('addresses.locality as locality')->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'families.category']);
        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(families.created_at) as month')->whereMonth('families.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(families.created_at) as year')->whereYear('families.created_at',  $request->query('year'))->groupBy('year');
        } 

        $report = $query->latest('families.created_at')->get()->groupBy('category'); 

        $totalCount = Family::count();

        $report = collect([
            'أ'     => $report->get('أرملة و ابناء', []),
            'ب'     => $report->get('أب و أم و أخوان و أخوات', []),
            'ج'     => $report->get('أخوات', []),
            'د'     => $report->get('مكتفية', []),
        ]);

        return ['report' => $report];

    }
}

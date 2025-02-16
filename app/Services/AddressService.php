<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

class AddressService 
{
    public function report()
    {
        $request = request();

        $query =  DB::table('addresses')->selectRaw('type, COUNT(id) as count')->groupBy('type');
                    
       if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('sector')->where('sector', $request->query('sector'))
            ->groupBy(['sector', 'type']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            
            $query->selectRaw('locality as locality')->where('locality', $request->query('locality'))
            ->groupBy(['sector', 'locality', 'type']);

        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(addresses.created_at) as month')->whereMonth('addresses.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(addresses.created_at) as year')->whereYear('addresses.created_at',  $request->query('year'))->groupBy('year');
        } 

        $report = $query->groupBy('type')->get();
        $report = $report->groupBy('type'); // خليها كدا و ما تهبشها عليك الله
        
        return ['report' => $report];
  
    }
}

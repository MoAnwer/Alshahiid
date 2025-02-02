<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class GrossController extends Controller
{

    public function getRportForm(string $view)
    {
        return DB::table($view)->get();
    }

    public function gross()
    {
        
        $reports = Cache::remember('gross', 10, function () {
            return collect([
    
                'assistances'        => $this->getRportForm('assistances_report')->groupBy('status'),
                'bails'              => $this->getRportForm('bails_report')->groupBy('status'),
                'home_services'      => $this->getRportForm('home_services_report')->groupBy('status'),
                'injured_services'   => $this->getRportForm('injured_services_report')->groupBy('status'),
                'projects'           => $this->getRportForm('projects_report')->groupBy('status'),
                'education_services' => $this->getRportForm('education_services_report')->groupBy('status'),
                'medical_treatments' => $this->getRportForm('medical_treatments_report')->groupBy('status'),
                'marry_assistances'  => $this->getRportForm('marry_assistances_report')->groupBy('status'),
                'martyr_docs'        => $this->getRportForm('martyr_docs_report')->groupBy('status'),
                'sessions'           => $this->getRportForm('sessions_report')->groupBy('status'),
                'camps'              => $this->getRportForm('camps_report')->groupBy('status'),
                'lectures'           => $this->getRportForm('lectures_report')->groupBy('status'),
                'hags'               => $this->getRportForm('hags_report')->groupBy('status'),
                'communicates'       => $this->getRportForm('communicates_report')->groupBy('status')
    
            ]);
        });

        //dd($reports);



        $totalNeed = 0;
        $totalDone = 0;
        $totalBudget = 0;
        $totalBudgetFromOrg = 0;
        $totalBudgetOutOfOrg = 0;
        $totalMoney = 0;

        foreach($reports as $report) :
           $totalNeed    += @$report['مطلوب'][0]->count ?? 0;
           $totalDone    += @$report['منفذ'][0]->count ?? 0;
           $totalBudget  += (@$report['مطلوب'][0]->budget ?? 0) + (@$report['منفذ'][0]->budget ?? 0);

           $totalBudgetFromOrg  += (@$report['مطلوب'][0]->budget_from_org ?? 0) + (@$report['منفذ'][0]->budget_from_org ?? 0);

           $totalBudgetOutOfOrg  += (@$report['مطلوب'][0]->budget_out_of_org ?? 0) + (@$report['منفذ'][0]->budget_out_of_org ?? 0);

           $totalMoney += (@$report['مطلوب'][0]->totalMoney ?? 0) + (@$report['منفذ'][0]->totalMoney ?? 0);
        endforeach;
        
        // dd($totalBudgetFromOrg);

        $report = [
            'need' => $totalNeed,
            'done' => $totalDone,
            'budget' => $totalBudget,
            'budgetFromOrg' => $totalBudgetFromOrg,
            'budgetOurOfOrg' => $totalBudgetOutOfOrg,
            'totalMoney'    => $totalMoney
        ];

        //dd($report);


        return view('reports.gross', compact('report'));
    }
}

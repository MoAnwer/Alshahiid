<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class GrossController extends Controller
{
    protected $request;

    public function __construct()
    {
        $this->request = request();
    }

    public function reportOf(string $table)
    {
        $query = DB::table("$table")
                ->leftJoin("addresses", "addresses.family_id", "$table.family_id")
                ->selectRaw("
                    $table.status as status,
                    SUM($table.budget) as  budget,  
                    SUM($table.budget_from_org) as budget_from_org,
                    SUM($table.budget_out_of_org)  as budget_out_of_org,                   
                    SUM($table.budget_out_of_org + $table.budget_from_org)  as totalMoney,
                    COUNT($table.id) as count
                ", 
                )->groupBy("$table.status");


        if (!empty($this->request->query('sector')) && $this->request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $this->request->query('sector'))
            ->groupBy(['addresses.sector', "$table.status"]);
        } 

        if (!empty($this->request->query("locality")) && $this->request->query("locality") != "all") {
            $query->selectRaw("addresses.locality as locality")->where("addresses.locality", $this->request->query("locality"))
            ->groupBy(["addresses.sector", "addresses.locality", "$table.status"]);
        } 

        if (!is_null($this->request->query("month")) && $this->request->query("month") != '') {
            $query->selectRaw("MONTH($table.created_at) as month")->whereMonth("$table.created_at",  $this->request->query("month"))->groupBy("month");
        } 

        if (!is_null($this->request->query("year")) && $this->request->query("year") != '') {
            $query->selectRaw("YEAR($table.created_at) as year")->whereYear("$table.created_at",  $this->request->query('year'))->groupBy('year');
        } 

        $report = $query->get()->groupBy('status');

        return $report;
    }

    public function educationReport() {

        $query = DB::table('education_services')
                ->join('students', 'students.id', 'education_services.student_id')
                ->join('family_members', 'family_members.id', 'students.family_member_id')
                ->join('families', 'families.id', 'family_members.family_id')
                ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                ->selectRaw('
                    education_services.status as status,
                    SUM(education_services.budget) as  budget,  
                    SUM(education_services.budget_from_org) as budget_from_org,
                    SUM(education_services.budget_out_of_org)  as budget_out_of_org,                   
                    SUM(education_services.budget_out_of_org + education_services.budget_from_org)  as totalMoney,
                    COUNT(education_services.status) as count
                ', 
                )->groupBy(['education_services.status']);


        if (!empty($this->request->query('sector')) && $this->request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $this->request->query('sector'))
            ->groupBy(['addresses.sector', 'education_services.status']);
        } 

        if (!empty($this->request->query('locality')) && $this->request->query('locality') != 'all') {
            $query->selectRaw('addresses.locality as locality')->where('addresses.locality', $this->request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'education_services.status']);
        } 

        if (!is_null($this->request->query('month')) && $this->request->query('month') != '') {
            $query->selectRaw('MONTH(education_services.created_at) as month')->whereMonth('education_services.created_at',  $this->request->query('month'))->groupBy('month');
        } 

        if (!is_null($this->request->query('year')) && $this->request->query('year') != '') {
            $query->selectRaw('YEAR(education_services.created_at) as year')->whereYear('education_services.created_at',  $this->request->query('year'))->groupBy('year');
        } 

        $report = $query->get()->groupBy('status');

        return $report;

    }

    public function medicalTreatments()
    {
        $request    = request();
        
        $query = DB::table('family_members')
                ->join('families', 'family_members.family_id', 'families.id')
                ->join('martyrs', 'families.martyr_id', 'martyrs.id')
                ->join('medical_treatments', 'medical_treatments.family_member_id', 'family_members.id')
                ->leftJoin('addresses', 'addresses.family_id', 'family_members.family_id')
                ->selectRaw('
                    medical_treatments.status as status,
                    SUM(medical_treatments.budget) as totalBudget,  
                    SUM(medical_treatments.budget_from_org) as budget_from_org,
                    SUM(medical_treatments.budget_out_of_org)  as budget_out_of_org,                   
                    SUM(medical_treatments.budget_out_of_org + medical_treatments.budget_from_org)  as totalMoney,
                    COUNT(medical_treatments.id) as count
                ', 
                )->groupBy('medical_treatments.status');

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector', 'medical_treatments.status']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->selectRaw('addresses.locality as locality')->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'medical_treatments.status']);
        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(medical_treatments.created_at) as month')->whereMonth('medical_treatments.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(medical_treatments.created_at) as year')->whereYear('medical_treatments.created_at',  $request->query('year'))->groupBy('year');
        } 

        $report = $query->get()->groupBy('status');

        return $report;
    }

    public function injuredServicesReport()
    {
        
        $query = DB::table('injured_services')
                ->leftJoin('injureds', 'injureds.id', 'injured_services.injured_id')
                ->selectRaw('
                    injured_services.status as status,
                    SUM(injured_services.budget) as  budget,  
                    SUM(injured_services.budget_from_org) as budget_from_org,
                    SUM(injured_services.budget_out_of_org)  as budget_out_of_org,                   
                    SUM(injured_services.budget_out_of_org + injured_services.budget_from_org)  as totalMoney,
                    COUNT(injured_services.status) as count
                ', 
                )->groupBy(['injured_services.status']);


        if (!empty($this->request->query('sector')) && $this->request->query('sector') != 'all') {
            $query->selectRaw('injureds.sector as sector')->where('injureds.sector', $this->request->query('sector'))
            ->groupBy(['injureds.sector', 'injured_services.status']);
        } 

        if (!empty($this->request->query('locality')) && $this->request->query('locality') != 'all') {
            $query->selectRaw('injureds.locality as locality')->where('injureds.locality', $this->request->query('locality'))
            ->groupBy(['injureds.sector', 'injureds.locality', 'injured_services.status']);
        } 

        if (!is_null($this->request->query('month')) && $this->request->query('month') != '') {
            $query->selectRaw('MONTH(injured_services.created_at) as month')->whereMonth('injured_services.created_at',  $this->request->query('month'))->groupBy('month');
        } 

        if (!is_null($this->request->query('year')) && $this->request->query('year') != '') {
            $query->selectRaw('YEAR(injured_services.created_at) as year')->whereYear('injured_services.created_at',  $this->request->query('year'))->groupBy('year');
        } 

        $report = $query->get()->groupBy('status');

        return $report;

    }

    public function marryAssistances()
    {

        $query = DB::table('marry_assistances')
                ->join('family_members',  'family_members.id', 'marry_assistances.family_member_id')
                ->join('families',  'families.id', 'family_members.family_id')
                ->join('martyrs','martyrs.id', 'families.martyr_id')
                ->join('addresses', 'addresses.family_id', 'families.id')
                ->selectRaw('
                    marry_assistances.status as status,
                    SUM(marry_assistances.budget) as  budget,  
                    SUM(marry_assistances.budget_from_org) as budget_from_org,
                    SUM(marry_assistances.budget_out_of_org)  as budget_out_of_org,                   
                    SUM(marry_assistances.budget_out_of_org + marry_assistances.budget_from_org)  as totalMoney,
                    COUNT(marry_assistances.status) as count
                ', 
                )->groupBy(['marry_assistances.status']);


        if (!empty($this->request->query('sector')) && $this->request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $this->request->query('sector'))
            ->groupBy(['addresses.sector', 'marry_assistances.status']);
        } 

        if (!empty($this->request->query('locality')) && $this->request->query('locality') != 'all') {
            $query->selectRaw('addresses.locality as locality')->where('addresses.locality', $this->request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'marry_assistances.status']);
        } 

        if (!is_null($this->request->query('month')) && $this->request->query('month') != '') {
            $query->selectRaw('MONTH(marry_assistances.created_at) as month')->whereMonth('marry_assistances.created_at',  $this->request->query('month'))->groupBy('month');
        } 

        if (!is_null($this->request->query('year')) && $this->request->query('year') != '') {
            $query->selectRaw('YEAR(marry_assistances.created_at) as year')->whereYear('marry_assistances.created_at',  $this->request->query('year'))->groupBy('year');
        }

        $report = $query->get()->groupBy('status');

        return $report;
    }

    
    public function taskiiaReportOf($table)
    {
        $report = DB::table($table)->selectRaw('
                status,
                SUM(budget) as budget,
                SUM(budget_from_org) as budget_from_org,
                SUM(budget_out_of_org) as budget_out_of_org,
                SUM(budget_out_of_org + budget_from_org) as totalBudget,
                count(id) as count
                '
        )->groupBy(['status']);

        if (($sector = request()->query('sector')) &&  $sector != 'all') {
            $report->selectRaw('sector')->where('sector', $sector)->groupBy('sector');
        }

        if (($locality = request()->query('locality'))&& $locality != 'all') {
            $report->selectRaw('locality')->where('locality', $locality)->groupBy('locality');
        }

        if (!is_null( request()->query('month')) &&  request()->query('month') != '') {
            $report->selectRaw('MONTH(created_at) as month')->whereMonth('created_at',   request()->query('month'))->groupBy('month');
        } 

        if (!is_null( request()->query('year')) &&  request()->query('year') != '') {
            $report->selectRaw('YEAR(created_at) as year')->whereYear('created_at',   request()->query('year'))->groupBy('year');
        }

        $report->groupBy('status');

                
        $report = $report->get()->groupBy('status');

        return $report;
    }

    public function martyrDocs()
    {
        $report = DB::table('martyr_docs')
                  ->join('martyrs', 'martyr_docs.martyr_id', 'martyrs.id')
                  ->join('families', 'families.martyr_id', '=', 'martyrs.id')
                  ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                  ->selectRaw('
                    martyr_docs.status,
                    SUM(martyr_docs.budget) as budget,
                    SUM(martyr_docs.budget_from_org) as budget_from_org,
                    SUM(martyr_docs.budget_out_of_org) as budget_out_of_org,
                    SUM(martyr_docs.budget_out_of_org + budget_from_org) as totalBudget,
                    count(*) as count
                ')->groupBy('martyr_docs.status');

        if (($sector = request()->query('sector')) && request()->query('sector') != 'all') {
            $report->selectRaw('addresses.sector')->where('sector', $sector)->groupBy('sector');
        }

        if (($locality = request()->query('locality')) && request()->query('locality') != 'all') {
            $report->selectRaw('addresses.locality')->where('locality', $locality)->groupBy('locality');
        }

        if (!is_null( request()->query('month')) &&  request()->query('month') != '') {
            $report->selectRaw('MONTH(martyr_docs.created_at) as month')->whereMonth('martyr_docs.created_at',   request()->query('month'))->groupBy('month');
        } 

        if (!is_null( request()->query('year')) &&  request()->query('year') != '') {
            $report->selectRaw('YEAR(martyr_docs.created_at) as year')->whereYear('martyr_docs.created_at',   request()->query('year'))->groupBy('year');
        }

        $report->groupBy('status');
                
        $report = $report->get()->groupBy('status');

        return $report;
    }

    
    public function hagsReport()
    {
        $report = DB::table('family_members')
                  ->join('hags', 'hags.family_member_id', '=', 'family_members.id')
                  ->join('families', 'family_members.family_id', '=', 'families.id')
                  ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                  ->selectRaw('
                    hags.status,
                    SUM(hags.budget) as budget,
                    SUM(hags.budget_from_org) as budget_from_org,
                    SUM(hags.budget_out_of_org) as budget_out_of_org,
                    SUM(hags.budget_out_of_org + budget_from_org) as totalBudget,
                    count(*) as count
                ')->groupBy('hags.status');

        if (($sector = request()->query('sector')) && request()->query('sector') != 'all') {
            $report->selectRaw('addresses.sector')->where('sector', $sector)->groupBy('sector');
        }

        if (($locality = request()->query('locality')) && request()->query('locality') != 'all') {
            $report->selectRaw('addresses.locality')->where('locality', $locality)->groupBy('locality');
        }

         if (!is_null( request()->query('month')) &&  request()->query('month') != '') {
            $report->selectRaw('MONTH(hags.created_at) as month')->whereMonth('hags.created_at',   request()->query('month'))->groupBy('month');
        } 

        if (!is_null( request()->query('year')) &&  request()->query('year') != '') {
            $report->selectRaw('YEAR(hags.created_at) as year')->whereYear('hags.created_at',   request()->query('year'))->groupBy('year');
        }

        $report->groupBy('status');
                
        $report = $report->get()->groupBy('status');

        return $report;
    }

    public function martyrCommunicates()
    {
        $report = DB::table('communicates')
                  ->join('families', 'communicates.family_id', 'families.id')
                  ->join('martyrs', 'families.martyr_id', 'martyrs.id')
                  ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                  ->selectRaw('
                    communicates.status,
                    SUM(communicates.budget) as budget,
                    SUM(communicates.budget_from_org) as budget_from_org,
                    SUM(communicates.budget_out_of_org) as budget_out_of_org,
                    SUM(communicates.budget_out_of_org + budget_from_org) as totalBudget,
                    count(*) as count
                ')->groupBy('communicates.status');

        if (($sector = request()->query('sector')) && request()->query('sector') != 'all') {
            $report->selectRaw('addresses.sector')->where('sector', $sector)->groupBy('sector');
        }

        if (($locality = request()->query('locality')) && request()->query('locality') != 'all') {
            $report->selectRaw('addresses.locality')->where('locality', $locality)->groupBy('locality');
        }

        if (!is_null( request()->query('month')) &&  request()->query('month') != '') {
            $report->selectRaw('MONTH(communicates.created_at) as month')->whereMonth('communicates.created_at',   request()->query('month'))->groupBy('month');
        } 

        if (!is_null( request()->query('year')) &&  request()->query('year') != '') {
            $report->selectRaw('YEAR(communicates.created_at) as year')->whereYear('communicates.created_at',   request()->query('year'))->groupBy('year');
        }

        $report->groupBy('status');
                
        $report = $report->get()->groupBy('status');

        return $report;
    }


    public function gross()
    {
        
        $reports = collect([

            'assistances'        => $this->reportOf('assistances'),
            'bails'              => $this->reportOf('bails'),
            'home_services'      => $this->reportOf('home_services'),
            'injured_services'   => $this->injuredServicesReport(),
            'projects'           => $this->reportOf('projects'),
            'education_services' => $this->educationReport(),
            'medical_treatments' => $this->medicalTreatments(),
            'marry_assistances'  => $this->marryAssistances(),
            'martyr_docs'        => $this->martyrDocs(),
            'sessions'           => $this->taskiiaReportOf('sessions'),
            'camps'              => $this->taskiiaReportOf('camps'),
            'lectures'           => $this->taskiiaReportOf('lectures'),
            'hags'               => $this->hagsReport(),
            'communicates'       => $this->martyrCommunicates()
    
        ]);
        
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

        $report = [
            'need' => $totalNeed,
            'done' => $totalDone,
            'budget' => $totalBudget,
            'budgetFromOrg' => $totalBudgetFromOrg,
            'budgetOurOfOrg' => $totalBudgetOutOfOrg,
            'totalMoney'    => $totalMoney
        ];

        return view('reports.gross', compact('report'));
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ProjectService 
{
    public function report()
    {

        $request = request();

        $query = DB::table('projects')
                ->join('families', 'projects.family_id', 'families.id')
                ->join('martyrs', 'families.martyr_id', 'martyrs.id')
                ->leftJoin('addresses', 'addresses.family_id', 'projects.family_id')
                ->selectRaw('
                    projects.status as status,
                    projects.project_type as project_type,
                    SUM(projects.budget) as  budget,  
                    SUM(projects.budget_from_org) as budget_from_org,
                    SUM(projects.budget_out_of_org)  as budget_out_of_org,                   
                    SUM(projects.budget_out_of_org + projects.budget_from_org)  as totalMoney,
                    COUNT(projects.status) as count
                ', 
                )->groupBy(['projects.status', 'projects.project_type']);


        if (!empty($request->query('force')) && $request->query('force') != 'all') {
            $query->selectRaw('martyrs.force')->where('martyrs.force', $request->query('force'))
            ->groupBy(['martyrs.force', 'projects.status', 'projects.project_type']);
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector', 'projects.status', 'projects.project_type']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->selectRaw('addresses.locality as locality')->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'projects.status', 'projects.project_type']);
        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(projects.created_at) as month')->whereMonth('projects.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(projects.created_at) as year')->whereYear('projects.created_at',  $request->query('year'))->groupBy('year');
        } 

        $report = $query->get()->groupBy(['project_type', 'status']); 
        
        return $report;
    }



    
    public function projectsWorkStatusReport()
    {
        $request = request();

        $query = DB::table('projects')
                ->join('families', 'projects.family_id', 'families.id')
                ->join('martyrs', 'families.martyr_id', 'martyrs.id')
                ->leftJoin('addresses', 'addresses.family_id', 'projects.family_id')
                ->selectRaw('projects.work_status as work_status, COUNT(projects.work_status) as count')->groupBy('projects.work_status');

        if (!empty($request->query('force')) && $request->query('force') != 'all') {
            $query->selectRaw('martyrs.force')->where('martyrs.force', $request->query('force'))
            ->groupBy(['martyrs.force', 'projects.status', 'projects.project_type']);
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->selectRaw('addresses.sector as sector')->where('addresses.sector', $request->query('sector'))
            ->groupBy(['addresses.sector', 'projects.work_status']);
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->selectRaw('addresses.locality as locality')->where('addresses.locality', $request->query('locality'))
            ->groupBy(['addresses.sector', 'addresses.locality', 'projects.work_status']);
        } 

        if (!is_null($request->query('month')) && $request->query('month') != '') {
            $query->selectRaw('MONTH(projects.created_at) as month')->whereMonth('projects.created_at',  $request->query('month'))->groupBy('month');
        } 

        if (!is_null($request->query('year')) && $request->query('year') != '') {
            $query->selectRaw('YEAR(projects.created_at) as year')->whereYear('projects.created_at',  $request->query('year'))->groupBy('year');
        } 

        $report = $query->get()->groupBy('work_status');

      return $report;        
    }
}
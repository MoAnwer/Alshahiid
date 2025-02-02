<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\GlobalTotalReport;
use App\Models\Family;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    protected Project $project;

    public function __construct() 
    {
        $this->project = new Project;
    }

    public function create(int $family)
    {
        $family = Family::findOrFail($family);

        return view('projects.create', compact('family'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_name'      => 'string|required',
            'project_type'      => "required|in:جماعي,فردي",
            'status'            => 'required|in:مطلوب,منفذ',
            'budget'            => 'numeric|required',
            'budget_from_org'   => 'nullable|numeric',
            'budget_out_of_org' => 'nullable|numeric',           
            'manager_name'      => 'required',
            'notes'             => 'nullable|string',
            'provider'          => 'in:من داخل المنظمة,من خارج المنظمة',
            'monthly_budget'    => 'nullable|numeric',
            'expense'           => 'nullable|numeric',
            'work_status'       => 'required'
        ], [
			'project_name' 		=> 'اسم المشروع اجباري',
			'budget'			=> 'حقل المبلغ مطلوب',
            'manager_name'  => 'اسم مدير المشروع مطلوب'
		]);

        $data['family_id'] = $request->family_id;

        try {

            Project::create($data);

            return back()->with('success', 'تم انشاء المشروع بنجاح');

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $family, int $project)
    {
        try {

            $family  = Family::findOrFail($family);

            $project = $family->projects()->findOrFail($project);

            return view('projects.edit', compact('family', 'project'));

        } catch(Exception $e) {
            return $e->getMessage();
        }

    }

    public function update(Request $request, int $family, int $project)
    {
         $data = $request->validate([
                'project_name'      => 'string|required',
                'project_type'      => "required|in:جماعي,فردي",
                'status'            => 'required|in:مطلوب,منفذ',
                'budget'            => 'numeric|required',
                'budget_from_org'   => 'nullable|numeric',
                'budget_out_of_org' => 'nullable|numeric',           
                'manager_name'      => 'required',
                'notes'             => 'nullable|string',
                'provider'          => 'in:من داخل المنظمة,من خارج المنظمة',
                'monthly_budget'    => 'nullable|numeric',
                'expense'           => 'nullable|numeric',
                'work_status'       => 'required'
            ], [
                'manager_name'     => 'حقل اسم المدير اجباري',
                'budget'           => 'حقل المبلغ مطلوب',
                'project_name'     => 'حقل  اسم المشروع اجباري'
            ]);

        try {
                    
            $family  = Family::findOrFail($family);
            $project = $family->projects()->findOrFail($project);

            $project->update($data);

             return back()->with('success', 'تم تعديل المشروع بنجاح ');

        } catch(Exception $e) {

            return $e->getMessage();

        }

    }

    public function delete($id) {
        try {

            $project = Project::findOrFail($id);
            return view('projects.delete', compact('project'));

        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function destroy($id)
    {
         try {

            $project = Project::findOrFail($id);

            $familyId = $project->family->id;

            $project->delete();
            
            return to_route('families.socialServices', $familyId)->with('success', 'تم حذف المشروع بنجاح ');

        } catch(Exception $e) {

            return abort(404);

        }
    }
	
	public function report()
	{
        $request    = request();
        $reportQuery = null;

        if(($sector = $request->query('sector')) && ($locality = $request->query('locality'))) {
            $reportQuery = collect(DB::select('
                            SELECT 
                                SUM(projects.budget) as totalBudget,
                                projects.status, 
                                COUNT(projects.status) as count, 
                                projects.project_type,
                                SUM(projects.budget_from_org)  as budget_from_org,
                                SUM(projects.budget_out_of_org) as budget_out_of_org,
                                COUNT(*) as families_count,
                                addresses.sector,
                                addresses.locality                            
                            FROM
                                families
                            INNER JOIN
                                projects
                            ON families.id = projects.family_id

                            INNER JOIN
                               addresses 
                            ON
                            addresses.family_id = families.id

                            WHERE addresses.sector = ? AND addresses.locality = ?

                            GROUP BY 
                                projects.project_type, projects.status, addresses.sector,addresses.locality

                            ', [$sector, $locality]
                    ));
        } else  {
            $reportQuery = collect(DB::select('
                            SELECT 
                                SUM(budget) as totalBudget,
                                status, 
                                COUNT(status) as count, 
                                project_type,
                                SUM(budget_from_org)  as budget_from_org,
                                SUM(budget_out_of_org) as budget_out_of_org,
                                COUNT(*) as families_count                        
                            FROM
                                projects
                            GROUP BY 
                                projects.project_type, projects.status
                            '
            ));
        }
 

        $report = collect([
                'member' => collect([
                    'need'   => collect([]),
                    'done'   => collect([])
                ]),

                'team' => collect([
                    'need'   => collect([]),
                    'done'   => collect([])
                ])
        ]);

       

        $reportQuery->map(function($value, $key) use ($report) {
            if($value->status == 'مطلوب'  && $value->project_type == 'جماعي' ){
                $report->get('team')->get('need')[] = $value;
            } 

            if ($value->status == 'منفذ'  && $value->project_type == 'جماعي' ) {
                $report->get('team')->get('done')[] = $value;
            }
            if ($value->status == 'مطلوب'  && $value->project_type == 'فردي' ) {
               $report->get('member')->get('need')[] = $value;
            }
            if ($value->status == 'منفذ'  && $value->project_type == 'فردي' ) {
                $report->get('member')->get('done')[] = $value;
            }
        });

        //dd($collection);

		
        $report->prepend([
            'member' => round((($report->get('member')['done'][0]->count ?? 0) / ($report->get('member')['need'][0]->count ?? 1)) * 10, 1),
            'team'   => round((($report->get('team')['done'][0]->count ?? 0) / ($report->get('team')['need'][0]->count ?? 1)) * 10, 1),
            'total'  => round(
                (
                    ( ($report->get('member')['done'][0]->count ?? 0)  +  ($report->get('team')['done'][0]->count ?? 1))
                    /
                    (($report->get('member')['need'][0]->count ?? 0)  +  ($report->get('team')['need'][0]->count ?? 1))
                ) * 10
                  
            , 1)
        ], 'precentages');

        $report->prepend([
            'total_budget'               => 
                      (($report->get('member')['need'][0]->totalBudget ?? 0)  +  ($report->get('member')['done'][0]->totalBudget ?? 0))
                    + (($report->get('team')['need'][0]->totalBudget ?? 0)  +  ($report->get('team')['done'][0]->totalBudget ?? 0))

            ,
            'total_budget_from_org'      =>         
                      (($report->get('member')['need'][0]->budget_from_org ?? 0)  + ( $report->get('member')['done'][0]->budget_from_org ?? 0))
                    + (($report->get('team')['need'][0]->budget_from_org ?? 0)  +  ($report->get('team')['done'][0]->budget_from_org ?? 0))
            ,

            'total_budget_out_of_org'    => 
                      (($report->get('member')['done'][0]->budget_out_of_org ?? 0) + ($report->get('member')['need'][0]->budget_out_of_org ?? 0))
                    + (($report->get('team')['done'][0]->budget_out_of_org ?? 0) + ($report->get('team')['need'][0]->budget_out_of_org ?? 0))
            ,
            'total_money'                =>
                      (($report->get('member')['need'][0]->budget_from_org ?? 0)  + ( $report->get('member')['done'][0]->budget_from_org ?? 0))
                    + (($report->get('team')['need'][0]->budget_from_org ?? 0)  + ( $report->get('team')['done'][0]->budget_from_org ?? 0))
                    + (($report->get('member')['done'][0]->budget_out_of_org ?? 0) + ($report->get('member')['need'][0]->budget_out_of_org ?? 0))
                    + (($report->get('team')['done'][0]->budget_out_of_org ?? 0) + ($report->get('team')['need'][0]->budget_out_of_org ?? 0))

        ], 'totals');

        //dd($report);

		return view('reports.projects', compact('report'));
	}


    public function projectsWorkStatusReport()
    {

        if(($sector = request()->query('sector')) && ($locality = request()->query('locality'))) {
                $work = DB::select('
                                SELECT 
                                    COUNT(projects.work_status) as count,
                                    addresses.sector,
                                    addresses.locality
                                FROM
                                    projects
                                INNER JOIN
                                    addresses
                                ON 
                                    addresses.family_id = projects.family_id
                                WHERE
                                    projects.work_status = "يعمل"
    
                                and addresses.sector = ? AND addresses.locality = ?
    
                                GROUP BY
                                    addresses.sector, addresses.locality, projects.work_status
                    ', [$sector, $locality]);

            $doesNotWork =  DB::select('
                     SELECT 
                         COUNT(projects.work_status) as count,
                         addresses.sector,
                         addresses.locality
                     FROM
                         projects
                     INNER JOIN
                         addresses
                     ON 
                         addresses.family_id = projects.family_id
                     WHERE
                        projects.work_status = "لا يعمل"
     
                     and addresses.sector = ? AND addresses.locality = ?
     
                     GROUP BY
                         addresses.sector, addresses.locality, projects.work_status
                ', [$sector, $locality]);

            $report = collect([
                'work'        => (@$work[0]->count) ?? 0,
                'doesNotWork' => (@$doesNotWork[0]->count) ?? 0,
                'total'       => (@$doesNotWork[0]->count ?? 0) + (@$work[0]->count ?? 0)
            ]);

            return view('reports.projectsWorkStatusReport', compact('report'));
        }

        $work = DB::table('projects')->where('work_status', 'يعمل')->count();

        $doesNotWork = DB::table('projects')->where('work_status', 'لا يعمل')->count();

        $report = collect([
            'work'        => $work,
            'doesNotWork' => $doesNotWork,
            'total'       => $doesNotWork + $work
        ]);

        return view('reports.projectsWorkStatusReport', compact('report'));
    }
}

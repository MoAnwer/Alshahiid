<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\Family;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    protected $log;
    protected Family $family;
    protected Project $project;
    protected ProjectService $projectService;

    public function __construct() 
    {
        $this->family  = new Family;
        $this->project = new Project;
        $this->projectService = new ProjectService;
        $this->log  = Log::stack(['stack' => Log::build(['driver' => 'single', 'path' => storage_path('logs/alshahiid.log')]) ]);
    }


    public function index() 
    {
        $request = request();

        $needel  = $request->query('needel');

        $query = DB::table('projects')
            ->leftJoin('families', 'projects.family_id', '=', 'families.id')
            ->leftJoin('addresses', 'addresses.family_id', '=','families.id')
            ->leftJoin('martyrs', 'martyrs.id', '=', 'families.martyr_id')
            ->select(
                'addresses.sector as sector',
                'addresses.locality as locality',
                'families.martyr_id',
                'families.id',
                'projects.id as project_id',
                'projects.manager_name as manager_name',
                'projects.project_type as project_type',
                'projects.project_name as project_name',
                'projects.status as status',
                'projects.work_status as work_status',
                'projects.budget as budget',
                'projects.budget_from_org as budget_from_org',
                'projects.budget_out_of_org as budget_out_of_org',
                'projects.expense as expense',
                'projects.monthly_budget as monthly_budget',
                'projects.created_at as created_at',
                'martyrs.name as martyr_name',
                'martyrs.force as force',
                'projects.family_id as family_id'
            );

        if ($request->query('search') == 'project_name') {
            $query->where('projects.project_name', 'LIKE', "%{$needel}%");
        }

        if ($request->query('search') == 'manager_name') {
            $query->where('projects.manager_name', 'LIKE', "%{$needel}%");
        }

        if ($request->query('search') == 'force') {
            $query->where('martyrs.force', $needel);
        }

        if ($request->query('search') == 'martyr_name') {
            $query->where('martyrs.name', $needel);
        }

        if (!empty($request->query('status')) && $request->query('status') != 'all') {
            $query->where('projects.status', $request->query('status'));
        } 

        if (!empty($request->query('work_status')) && $request->query('work_status') != 'all') {
            $query->where('projects.work_status', $request->query('work_status'));
        } 

        if (!empty($request->query('project_type')) && $request->query('project_type') != 'all') {
            $query->where('projects.project_type', $request->query('project_type'));
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        if (!empty($request->query('year')) && $request->query('year') != 'all') {
            $query->whereYear('projects.created_at', $request->query('year'));
        } 

        if (!empty($request->query('month')) && $request->query('month') != 'all') {
            $query->whereMonth('projects.created_at', $request->query('month'));
        } 

        $projects = $query->latest('projects.id')->paginate(10);

        return view('projects.index', ['projects' => $projects]);

    }



    // عرض قاءمة مشاريع خاصة باسرة الاـ id بتاعها $family
    public function family($family)
    {
        return view('families.socialServices.projects', [
            'projects'           => $this->project->where('family_id', $family)->paginate(),
            'family_with_martyr' =>  $this->family->where('id', $family)->select('id', 'martyr_id')->with('martyr:id,name')->get()
        ]);
    }

    public function create(int $family)
    {   
        return view('projects.create', ['family' => $this->family->findOrFail($family)->loadMissing('martyr')]);
    }

    public function store(ProjectRequest $request, $family)
    {
        $data = $request->validated();

        try {

            $this->family->findOrFail($family)->projects()->create($data);


            
            return back()->with('success', 'تم انشاء مشروع '. $data['project_name'] .' بنجاح');

        } catch (Exception $e) {
            $exception = $e->getMessage();
            $this->log->error('Storing project ', ['exception' => $exception]);
            return $exception;
        }
    }

    public function edit(int $id)
    {
        try {

            $project  = $this->project->findOrFail($id)->loadMissing('family');

            return view('projects.edit', compact('project'));

        } catch (Exception $e) {
            $exception = $e->getMessage();
            $this->log->error('Edit project id='. $id, ['exception' => $exception]);
            return $exception;
        }

    }

    public function update(ProjectRequest $request, int $id)
    {
        $data = $request->validated();

        try {        

            $project = $this->project->findOrFail($id);
            $project->update($data);

         

            return back()->with('success', 'تم تعديل المشروع بنجاح ');

        } catch (Exception $e) {
            $exception = $e->getMessage();
            $this->log->error('Update project id=' . $id . ['exception' => $exception]);
            return $exception;
        }

    }

    public function delete($id) {
        return view('projects.delete', ['project' => $this->project->findOrFail($id)]);
    }

    public function destroy($id)
    {
        try {

            $project = $this->project->findOrFail($id)->loadMissing('family');
            $name = $project->project_name;
            $family = $project->family->id;
            $project->delete();

       
            return to_route('families.socialServices', $family)->with('success', 'تم حذف مشروع  ' . $name . 'بنجاح ');

        } catch(Exception $e) {
            $exception = $e->getMessage();
            $this->log->error("Delete project id=$id" , ['Exception' => $exception]);
            return $exception;
        }
    }
	
	public function report()
	{
		return view('reports.projects', ['report' => $this->projectService->report()]);
	}

    public function projectsWorkStatusReport()
    {
        return view('reports.projectsWorkStatusReport', ['report' => $this->projectService->projectsWorkStatusReport()]);
    }
}

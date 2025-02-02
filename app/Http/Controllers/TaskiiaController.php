<?php

namespace App\Http\Controllers;

use App\Models\Martyr;
use App\Models\Hag;
use Illuminate\Support\Facades\DB;

class TaskiiaController extends Controller
{

    public function martyrsDocsList()
    {
        return view('tazkiia.martyrsDocsList', ['martyrs' => Martyr::with('martyrDoc')->orderByDESC('id')->paginate()]);
    }

    public function hagsMembersList()
    {
        return view('tazkiia.hagsMembersList', ['hags' => Hag::where('family_member_id', '!=', null)->orderByDESC('id')->paginate()]);
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
        )->groupBy('status')->get();
                
        $report = $report->groupBy('status');

        return $report;
    }

    public function report() {

        $report = collect([
            'sessions'      => $this->taskiiaReportOf('sessions'),
            'camps'         => $this->taskiiaReportOf('camps'),
            'lectures'      => $this->taskiiaReportOf('lectures'),
            'hags'          => $this->taskiiaReportOf('hags'),
            'martyrsDocs'   => $this->taskiiaReportOf('martyr_docs'),
            'martyrCom'     => $this->taskiiaReportOf('communicates')
        ]);

        return view('reports.tazkiia', compact('report'));
    }
}

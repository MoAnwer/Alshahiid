<?php

namespace App\Http\Controllers;

use App\Models\Martyr;
use App\Models\Hag;
use Illuminate\Support\Facades\DB;

class TaskiiaController extends Controller
{

    public function martyrsDocsList()
    {

        $request = request();

        $needel = trim(htmlentities($request->query('needel')));

        $query = DB::table('martyrs')
                ->leftJoin('families', 'families.martyr_id', '=',  'martyrs.id')
                ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                ->select(
                    'addresses.sector as sector',
                    'addresses.locality as locality',
                    'families.martyr_id',
                    'families.id',
                    'martyr_docs.id as doc_id',
                    'martyr_docs.storage_path as storage_path',
                    'martyr_docs.status as status',
                    'martyr_docs.budget as budget',
                    'martyr_docs.budget_from_org as budget_from_org',
                    'martyr_docs.budget_out_of_org as budget_out_of_org',
                    'martyr_docs.created_at as created_at',
                    'martyrs.id as martyr_id',
                    'martyrs.name as martyr_name',
                    'martyrs.unit as martyr_unit',
                    'martyrs.force as force',
                );


        if ($request->query('search') == 'force') {
            $query->where('martyrs.force', $needel);
        }

        if ($request->query('search') == 'unit') {
            $query->where('martyrs.unit', $needel);
        }

        if ($request->query('search') == 'martyr_name') {
            $query->where('martyrs.name', $needel);
        }

        if (!empty($request->query('isTrue')) && $request->query('isTrue') != 'all') {
           if ($request->query('isTrue') == 'yes') {
                $query->join('martyr_docs', 'martyr_docs.martyr_id', '=', 'martyrs.id')->where('martyr_docs.status', 'منفذ');
           } else {
                $query->join('martyr_docs', 'martyr_docs.martyr_id', '=', 'martyrs.id');
           }
        } else {
             $query->join('martyr_docs', 'martyr_docs.martyr_id', '=', 'martyrs.id');
        }


        if (!empty($request->query('status')) && $request->query('status') != 'all') {
            $query->where('martyr_docs.status', $request->query('status'));
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        if (!empty($request->query('year')) && $request->query('year') != 'all') {
            $query->whereYear('martyr_docs.created_at', $request->query('year'));
        } 

        if (!empty($request->query('month')) && $request->query('month') != 'all') {
            $query->whereMonth('martyr_docs.created_at', $request->query('month'));
        } 

        $martyr_docs = $query->latest('martyr_docs.created_at')->paginate();


        return view('tazkiia.martyrsDocsList', compact('martyr_docs'));
    }

    public function hagsMembersList()
    {
        $request = request();

        $needel = trim(htmlentities($request->query('needel')));

        $query = DB::table('family_members')
                ->join('hags', 'hags.family_member_id', '=', 'family_members.id')
                ->join('families', 'family_members.family_id', '=', 'families.id')
                ->leftJoin('addresses', 'addresses.family_id', 'families.id')
                ->leftJoin('martyrs', 'martyrs.id', '=', 'families.martyr_id')
                ->select(
                    'addresses.sector as sector',
                    'addresses.locality as locality',
                    'family_members.id as member_id',
                    'families.martyr_id',
                    'families.id',
                    'hags.id as hag_id',
                    'hags.type as type',
                    'hags.status as status',
                    'hags.budget as budget',
                    'hags.budget_from_org as budget_from_org',
                    'hags.budget_out_of_org as budget_out_of_org',
                    'hags.created_at as created_at',
                    'martyrs.name as martyr_name',
                    'martyrs.force as force',
                    'family_members.name as name',
                    'family_members.relation as relation',
                    'family_members.gender as gender',
                    'family_members.family_id as family_id'
                );


        if ($request->query('search') == 'name') {
            $query->where('family_members.name', 'LIKE', "%{$needel}%");
        }

        if (!empty($request->query('gender')) && $request->query('gender') != 'all') {
            $query->where('family_members.gender', $request->query('gender'));
        } 

        if (!empty($request->query('relation')) && $request->query('relation') != 'all') {
            $query->where('family_members.relation', $request->query('relation'));
        } 

        if ($request->query('search') == 'force') {
            $query->where('martyrs.force', $needel);
        }

        if ($request->query('search') == 'martyr_name') {
            $query->where('martyrs.name', $needel);
        }

        if (!empty($request->query('type')) && $request->query('type') != 'all') {
            $query->where('hags.type', $request->query('type'));
        } 

        if (!empty($request->query('status')) && $request->query('status') != 'all') {
            $query->where('hags.status', $request->query('status'));
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('addresses.sector', $request->query('sector'));
        } 

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('addresses.locality', $request->query('locality'));
        } 

        if (!empty($request->query('year')) && $request->query('year') != 'all') {
            $query->whereYear('hags.created_at', $request->query('year'));
        } 

        if (!empty($request->query('month')) && $request->query('month') != 'all') {
            $query->whereMonth('hags.created_at', $request->query('month'));
        } 

        $hags = $query->latest('hags.created_at')->paginate();

        return view('tazkiia.hagsMembersList', compact('hags'));
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

    public function report() {

        $report = collect([
            'sessions'      => $this->taskiiaReportOf('sessions'),
            'camps'         => $this->taskiiaReportOf('camps'),
            'lectures'      => $this->taskiiaReportOf('lectures'),
            'hags'          => $this->hagsReport(),
            'martyrsDocs'   => $this->martyrDocs(),
            'martyrCom'     => $this->martyrCommunicates()
        ]);

        return view('reports.tazkiia', compact('report'));
    }
}

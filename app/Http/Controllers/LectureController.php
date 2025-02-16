<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Lecture;
use App\Http\Requests\LectureRequest;
use Illuminate\Support\Facades\DB;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $request = request();

        $lectName = trim(htmlentities($request->query('name')));

        $query = DB::table('lectures')
                ->select('id','budget', 'name', 'budget_out_of_org', 'budget_from_org', 'notes', 'status',  'sector', 'date', 'locality', 'sector', 'locality');

        if (!empty($lectName)) {
            $query->where('name', 'LIKE', "%$lectName%");
        }

        if (!empty($request->query('date'))) {
            $query->where('date', $request->query('date'));
        }


        if (!empty($request->query('status')) && $request->query('status') != 'all') {
            $query->where('status', $request->query('status'));
        } 

        if (!empty($request->query('sector')) && $request->query('sector') != 'all') {
            $query->where('sector', $request->query('sector'));
        }

        if (!empty($request->query('locality')) && $request->query('locality') != 'all') {
            $query->where('locality', $request->query('locality'));
        }

        $lectures = $query->latest('id')->paginate(10);

        return view('tazkiia.lectures.index', compact('lectures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tazkiia.lectures.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LectureRequest $request)
    {
        $data = $request->validated();

        try {
            Lecture::create($data);

            return back()->with('success', 'تم اضافة محاضرة بعنوان  ' . $data['name'] . ' بنجاح ');

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
    public function edit($id)
    {
        return view('tazkiia.lectures.edit', ['lecture' => Lecture::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LectureRequest $request, $id)
    {
        $data = $request->validated();

        try {
            Lecture::findOrFail($id)->update($data);

            return back()->with('success', 'تم تعديل محاضرة بعنوان  ' . $data['name'] . ' بنجاح ');
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function delete($id)
    {
        return view('tazkiia.lectures.delete', ['lecture' => Lecture::findOrFail($id)]);
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
            $lect = Lecture::findOrFail($id);
            $lectName = $lect->name;
            $lect->delete();

            return to_route('tazkiia.lectures.index')->with('success', ' تم حذف محاضرة ' . $lectName);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}

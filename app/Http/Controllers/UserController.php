<?php

namespace App\Http\Controllers;

use Throwable;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isModerate');

        return view('users.users', ['users' => User::orderByDESC('id')->paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('isModerate');
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $this->authorize('isModerate');

        $data = $request->validated();
        $data['password'] = bcrypt($request->password);

        try {
            User::create($data);
            return back()->with('success', 'تم اضافة المستخدم بنجاح');

        } catch (Throwable $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $this->authorize('isModerate');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('isModerate');
        return view('users.edit', ['user' => User::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isModerate');

        $data     =  [];
        $messages =  [];
        $request->username = trim($request->username);
        $request->password = trim($request->password);

        if ($request->username) {
            $data['username'] = 'unique:users,username';
            $messages['username.unique']   = 'اسم المستخدم هذا غير متاح, جرب اسم اخر';
        }


        if ($request->full_name) {
            $data['full_name'] = 'string';
            $messages['full_name'] = 'الاسم الرباعي مطلوب';
        }


        if (!empty($request->password)) {
            $data['password'] = 'min:6';
            $messages['password.min'] ='كلمة السر يجب ان تكون من 6 احرف على الاقل';
            $date['password'] = bcrypt($request->password);
        }

        if ($request->role) {
            $data['role'] = 'in:user,admin,moderate';
        }

        $data = $request->validate($data, $messages);

        User::findOrFail($id)->update($data);

        return to_route('users.index')->with('success', 'تم تعديل المستخدم بنجاح');
        
    }

    public function delete($id)
    {
        return view('users.delete', ['user' => User::findOrFail($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request, int $id)
    {
        
        if(Hash::check($request->password, auth()->user()->password)) {
            
            try {

                User::findOrFail($id)->delete();
                return to_route('users.index')->with('success', 'تم الحذف بيانات المستخدم بنجاح');

            } catch (Throwable $e) {
                return $e->getMessage();
            }

        } else {
            return back()->with('error', 'كلمة السر غير  صحيحة');
        }
    }
}

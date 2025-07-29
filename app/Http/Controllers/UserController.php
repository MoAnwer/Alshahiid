<?php

namespace App\Http\Controllers;

use Throwable;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\{User, Martyr, Family};
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected User $user;
    protected Martyr $martyr;
    protected Family $family;


    public function __construct()
    {
        $this->martyr = new Martyr;
        $this->family = new Family;
        $this->user   = new User;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('admin-or-moderate');

        return view('users.users', ['users' => User::orderByDESC('id')->paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('admin-or-moderate');
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
        $this->authorize('admin-or-moderate');

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
       $this->authorize('admin-or-moderate');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('admin-or-moderate');
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
        $this->authorize('admin-or-moderate');

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
        $this->authorize('isModerate');
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



    /**
     * show how many martyrs and families that added by this user today
     */
    public function userLog(int $user)
    {
        try {
                
            $this->authorize('admin-or-moderate');

            // this method show the count of families & martyr that added by "$user" in this day

            $martyrsStats = $this->martyr->where('user_id', $user)->whereDate('created_at', today())->count();
            $familiesStats = $this->family->where('user_id', $user)->whereDate('created_at', today())->count();
            $user = $this->user->findOrFail($user);
            $printType = 'userLog';

            return view('users.userLog', compact('user', 'martyrsStats', 'familiesStats', 'printType'));
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

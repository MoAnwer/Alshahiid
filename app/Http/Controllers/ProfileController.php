<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('users.profile');
    }

    public function update(Request $request)
    {
        $data = [];

        $messages = [
            'password.min'  => 'كلمة السر يحب ان تتكون من 6 احرف عللى الاقل',
            'username.unique'  => 'اسم المستخدم موجود بالفعل'
        ];

        try {
            
            $user = Auth::user();


        if (!empty($request->password)) {

            if (empty($request->username)) {
                $data = $request->validate([
                    'full_name' => 'nullable|string',
                    'password'  => 'string|max:16|min:6'
                ], $messages); 

                $user->full_name = $data['full_name'];
                $user->password = bcrypt($data['password']);
                $user->save();

            } else {
                $data = $request->validate([
                    'username'  => 'unique:users,username',
                    'full_name' => 'nullable|string',
                    'password'  => 'string|max:16|min:6'
                ], $messages);
            

            $user->username = $data['username'];
            $user->full_name = $data['full_name'];
            $user->password = bcrypt($data['password']);
            $user->save();

            }


        } else {


             if (empty($request->username)) {
                $data = $request->validate([
                    'full_name' => 'nullable|string',
                ], $messages); 

                $user->full_name = $data['full_name'];
                $user->save();

            } else {
                $data = $request->validate([
                    'username'  => 'unique:users,username',
                    'full_name' => 'nullable|string',
                ], $messages);

                $user->username = $data['username'];
                $user->full_name = $data['full_name'];
                $user->save();
            }

        }

            return back()->with('success', 'تم تعديل بياناتك بنجاح ' . auth()->user()->username);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}

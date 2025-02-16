<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    
    public function loginAction(AuthRequest $request)
    {
       try {
        
            $request->validated();
        
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {

                $request->session()->regenerate();

                return to_route('home');
            }

            return back()->withErrors([
                'username'      =>  trans('auth.failed')
            ]);

        } catch (Exception $e) {

            return response($e->getMessage());
        }

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    public function register()
    {
		$this->authorize('moderate');
    }
}

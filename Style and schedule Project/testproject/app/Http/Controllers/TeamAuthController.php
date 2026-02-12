<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TeamAuthController extends Controller
{
    protected $redirectTo = '/staff/dashboard';

    public function showLoginForm()
    {
        return view('staff.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $field = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::guard('team')->attempt([$field => $request->username, 'password' => $request->password])) {
            $user = Auth::guard('team')->user();
            $user->last_login = Carbon::now();
            $user->save();

            return redirect($this->redirectTo)->with('success', 'You are login');
        } else {
            return back()->with('error', 'These credentials do not match our records.');
        }
    }


    public function logout(Request $request)
    {
        Auth::guard('team')->logout();
        $request->session()->invalidate();

        return redirect('/');
    }
}

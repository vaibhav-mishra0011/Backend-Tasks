<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Log;
use Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('users.login');
    }
    public function login(Request $request)
    {
        Log::debug("Going to authenicate user $request->email");

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where("email", $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                // login the user if password matches
                Auth::login($user);
                $name = auth()->user()->name;
                return redirect()->route('tasks.index')->with('success', 'login successfully');
            } else {
                return back()->with('fail', 'password not matches');
            }

        } else {
            return redirect()->back()->with("fail", "This email is not registered");

        }

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Log;

class RegisterController extends Controller
{
    //
    public function index()
    {   
        return view('users.register');
    }
    public function register(Request $request){
        try {

            Log::debug('Got request to register user');
            Log::debug($request->all());

            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'name' => $request->name,
            ]);

            return view('users.login')->with('success','you have registered successfully');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->with('fail', 'something wrong');
        }

    }
}

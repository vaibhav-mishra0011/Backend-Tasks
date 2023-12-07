<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Log;

class AuthController extends Controller
{
    // public function login(Request $request)
    // {
    //     Log::debug("Going to authenicate user asd $request->email");

    //     $user = User::where('email', $request->email)->first();

    //     if (!Auth::attempt($request->only('email', 'password'))) {
    //         return response()->json([
    //             'message' => 'Invalid login details'
    //         ], 401);
    //     }
    //     Auth::login($user);
    //     $res = [
    //         'user' => $user,
    //         'role' => $user->roles->pluck('name')->toArray(),
    //     ];
    //     return response( $res, 201 );
    // }
    public function login(Request $request)
    {
        Log::debug("Going to authenicate user asd $request->email");

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }
        $request->session()->regenerate();
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        Auth::logout();
    }

    public function me(Request $request)
    {
        return response()->json([
            'data' => $request->user(),
            'role' => $request->user()->roles->pluck('name')->toArray(),
        ]);
    }

    public function register(Request $request)
    {
        try {

            // return $request->all();
            Log::debug('Got request to register user');
            Log::debug($request->all());

            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
        

            ]);
            $user->assignRole('user');
            $user->notify(new \App\Notifications\WelcomeMailNotification($user));

            if ($user) {
                return response()->json([
                    'status' => true,
                    'message' => 'Registered Successfully',
                ], 200);
                
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Something Went wrong'
                ], 500);
            }
            //return view('users.login')->with('success','you have registered successfully');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->with('fail', 'something wrong');
        }

    }
}

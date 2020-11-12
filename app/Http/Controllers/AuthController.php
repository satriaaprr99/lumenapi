<?php

namespace App\Http\Controllers;

use Auth;
use \App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function login(Request $request){

        $this->validate($request, [
            'username' => 'required|exists:users,username',
            'password' => 'required|string|min:6'
        ]);

        $user = User::where('username', $request->username)->first();
    
        if ($user && Hash::check($request->password, $user->password)) {
            $token = Str::random(40);
            $user->update(['remember_token' => $token]);
            return response()->json(['status' => 'success', 'data' => $token]);
        }
        return response()->json(['status' => 'error']);

    }

    public function register(Request $request){

        $this->validate($request, [
            'name' => 'required|max:50',
            'username' => 'required|unique:users|max:50',
            'password' => 'required'
        ]);

        $data = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
 
        return response()->json($data, 200);
    }
}

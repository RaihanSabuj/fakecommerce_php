<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PassportAuthController extends Controller
{
     /**
     * Registration
     */
    public function register(Request $request){
        $this->validate($request, [
            'firstname'=>'required|min:3',
            'email'=>'required|email',
            // 'role'=>'required',
            'username'=>'required|min:4',
            'password'=>'required|min:8',
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;
        return response()->json(['token'=>$token], 200);
    }
     /**
     * Login
     */
    public function login(Request $request)
    {
        $data = [
            'email'=>$request->email,
            // 'username'=>$request->username,
            'password'=>$request->password,
        ];

        if(auth()->attempt($data)){
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token'=>$token], 200);
        }else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }

    }
}

<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function signUp()
    {
        
        $data = request()->all();

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $resArr = [];
        $resArr['token'] = $user->createToken('api-application')->accessToken;
        $resArr['name'] = $user->name;
        $resArr['id'] = $user->id;

        return response()->json($resArr, 200);
    }
    public function login()
    {
        
        $user = User::where('email', request()->email)->first();
        if (!$user) {
            return response()->json(['error' => ' email not found'], 203);
        }

        if (!Hash::check(request()->password, $user->password)) {
            return response()->json(['error' => 'inncorrect password'], 203);
        }

        $resArr = [];
        $resArr['token'] = $user->createToken('api-application')->accessToken;
        $resArr['name'] = $user->name;
        $resArr['email'] = $user->email;
        $resArr['id'] = $user->id;
        return response()->json($resArr, 200);
    }

    public function UnAuthorized()
    {
        return response()->json('UnAuthorized', 203);
    }

  

  
}

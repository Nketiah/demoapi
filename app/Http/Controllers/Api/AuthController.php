<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' =>['required','string'],
            'password' =>['required','string']
         ]);

     $user = User::where('email', $request->email)->first();
    if(!$user || !Hash::check($request->password, $user->password))
    {
        return response()->json(["message" => "The provided credentials are incorrect."], 401);
    }
    $token = $user->createToken("access_token")->plainTextToken;
    $user->token = $token;
    return response()->json(["user" => $user], 200);

    }

    public function register(Request $request)
    {
        $request->validate([
           'name' =>['required','string'],
           'email' =>['required','string','email','unique:users'],
           'password' =>['required','string','confirmed']
        ]);

        $userData = $request->all();
        $userData["password"] = bcrypt($userData["password"]);
        User::create($userData);
        return response()->json(["message" => "User registered successfully"],201);
    }
    

    public function logout()
    {
        request()->user()->tokens()->delete();
        return response()->json(["message" => "User logged out successfully"], 200);

    }


    public function index()
    {
        $user = User::all();
        return response()->json($user);
    }
}

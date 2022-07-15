<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Eula;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;

class RegisterController extends Controller
{
    //

    function getUsers(){
        $users = User::get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Data",
            "data" => $users
        ], 200);
    }

    function getEula(){
        $eula = Eula::first();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Data",
            "data" => $eula
        ], 200);
    }
    
    function index(Request $request){
        try {

            $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'name' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'role' => 'required',
                'purok' => 'required',
                'password' => 'required|confirmed',
            ]);

            $user = new User();
            $user->email = $request->email;
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->name = $request->name;
            $user->role = $request->role;
            $user->purok = $request->purok;

            $str_rnd = Str::random(5);
            $user->remember_token = $str_rnd;
            $user->password = bcrypt($request->password);

            $user->save();

            if (!$token = auth()->attempt(["email" => $request->email, "password" => $request->password])) {
                return response()->json([
                    "errors" => [
                        "user" => 0
                    ],
                    "message" => "Cannot get token"
                ], 400);
            }

            $token = $request->user()->createToken($request->email);

            return response()->json([
                "status" => 1,
                "message" => "User registered successfully",
                "user_id" => $user->id,
                "token" => $token->plainTextToken
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                "status" => 0,
                "message" => $e->getMessage(),
            ], 200);
        }
    }
}

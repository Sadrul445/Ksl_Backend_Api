<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registration(Request $request)
    {
        //validation
        $data = $request->validate(
            [
                "name" => "required|string",
                "email" => "required|string|unique:users,email",
                "password" => "required|string|min:6|confirmed",
                "type" => "required|string|in:author,admin,moderator"
            ]
        );
        //create_user
        $user = User::create(
            [
                "name" => $data["name"],
                "email" => $data["email"],
                "password" => bcrypt($data["password"]),
                "type" => $data["type"]
            ]
        );
        //token_generate
        $token = $user->createToken('ksl_admin_token')->plainTextToken;
        
        $response = [
            "user" => [
                "id" =>$user->id,
                "name"=>$user->name,
                "email"=>$user->email,
                "type"=>$user->type
            ],
            "token" => $token
        ];

        return response($response, 201);
    }
    public function login(Request $request)
    {
        //validation
        $data = $request->validate(
            [
                "email" => "required|string",
                "password" => "required|string",
                "type" => "required|string|in:author,admin,moderator"
            ]
        );
        //checkEmail
        $user = User::where("email", $data['email'])->first();

        //checkPassword
        if (!$user || !Hash::check($data["password"], $user->password)) {
            return response([
                "message" => "Bad Credantials"
            ], 401);
        }
        //checkUser
        if ($user->type !== $data["type"]) {
            return response(
                [
                    "message" => "Do not permission to access the resource",
                    "note"    => "Make sure to insert your correct user_type"
                ],403
            );
        }
        //token_generate
        $token = $user->createToken('ksl_admin_token')->plainTextToken;
        $response = [
            "user" => $user,
            "token" => $token
        ];
        return response($response, 200);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return [
            "message" => "Admin Logged Out Successfully"
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController;
use Illuminate\Support\facades\Auth;
use Validator;

class AuthController extends BaseController
{
    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required",
            "password" => "required",
            "confirm_password" => "required|same:password",
        ]);

        if ($validator->fails()) {
            return $this->sendError("Error validation", $validator->errors(), 400);
        }
        $input = $request->all();
        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);
        $success["name"] = $user->name;
        return $this->sendResponse($success, "User created successfuly");
    }
    public function signIn(Request $request)
    {
        if (Auth::attempt(["name" => $request->name, "password" => $request->password])) {
            $authUser = Auth::user();
            $success["token"] = $authUser->createToken("adoptme")->plainTextToken;
            $success["name"] = $authUser->name;
            return $this->sendResponse($success, "User signed in");
        } else {
            return $this->sendError("Sikertelen bejelentkezés", ["error" => "Hibás adatok"], 400);
        }
    }
    public function signOut(Request $request)
    {
        auth("sanctum")->user()->currentAccessToken()->delete();
        return response()->json('Successfully logged out');
    }
}

<?php


namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function registry(Request $request) {
        $rules =  [
            "email" => "required|email|unique:users",
            "password" => "required|string|min:6|max:32"
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->messages()]);
        }
        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->uuid = Str::uuid();
        $user->save();
        return response()->json([
            "status" => true,
            "user" => $user
        ]);
    }
}

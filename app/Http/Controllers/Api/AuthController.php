<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helper\AllHelper;
use Auth;
use Validator;

class AuthController extends Controller
{
    //User Register
    public function register(Request $request) {
        //Validation of Data
        $validator = Validator::make(request()->all(),[
            'first_name' => 'required|min:1',
            'last_name' => 'required|min:1',
            'email' => 'required|min:3',
            'password' => 'required|min:6',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 500,
                'data' => $validator->errors()
            ]);
        }

        //Store User Data To Table
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 200,
            'data' => $user,
        ]);
    }

    //User Login
    public function login(Request $request) {
        //Validation of Data
        $validator = Validator::make(request()->all(),[
            'email' => 'required|min:3',
            'password' => 'required|min:6',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 500,
                'data' => $validator->errors()
            ]);
        }

        //Check email and password is correct.
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $token = $user->createToken('social');

            return response()->json([
                'status' => 200,
                'token' => $token->plainTextToken,
                'data' => $user,
            ]);
        }

        return response()->json([
            'status' => 500,
            'data' => [
                'error' => 'email_and_password_donot_match',
            ],
        ]);
    }

}

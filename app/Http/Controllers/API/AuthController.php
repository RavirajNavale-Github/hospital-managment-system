<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        //Validate the inputs
        $validateUser = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]
        );

        //Handling if error occurs
        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validateUser->errors()->all(),
            ], 401);
        }

        //save data in database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        //return success message
        return response()->json([
            'status' => true,
            'message' => 'User reistred successfully',
            'user' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        //Validate the inputs
        $validateUser = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        //Handling if error occurs
        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Authentication failed',
                'errors' => $validateUser->errors()->all(),
            ], 401);
        }

        //Authentication checks email and opassword is match to the data inside database
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            //extract user email and password
            $authUser = Auth::user();

            //return success message and creating token also sent to client 
            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'token' => $authUser->createToken('API Token')->plainTextToken,
                'token_type' => 'bearer'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Athentication failed',
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete(); //delete all the token from database for this user

        return response()->json([
            'status' => true,
            'user' => $user,
            'message' => 'User logged out successfully',
        ], 200);
    }
}

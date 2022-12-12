<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function createRegister(Request $request)
    {

        try {
            $validate = Validator::make($request->all(),[
                'fullname' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ]);
            if($validate->fails()){
                return response()->json([
                    'success' => false,
                    'errors' => $validate->errors(),
                    'status' => Response::HTTP_BAD_REQUEST,
                  ], Response::HTTP_BAD_REQUEST);
            }

            $user = User::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'is_active' => $request->is_active,
                'last_login' => $request->last_login,
                'role' => $request->role,
                'status' => $request->status,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'profile_img' => $request->profile_img,
                'provider' => $request->provider,
                'provider_id' => $request->provider_id,
                'provider_token' => $request->provider_token,
                'password'=>Hash::make($request->password),
            ]);

            return response()->json([
                'success' => true,
                'data'   => User::orderBy('id', 'desc')->first(),
                'message' => 'User created successfully!',
                'status' => Response::HTTP_CREATED,
            ], Response::HTTP_CREATED);


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
                'status' => Response::HTTP_CREATED,
              ], Response::HTTP_CREATED);
        }



    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return [
                "success" => true,
                "token" => "Bearer " . $user->createToken('CRM')->plainTextToken,
                "message" => "Login Successfully!",
                "data" => $user,
            ];
        }else{
            return [
                "success" => false,
                "message" => "Credentials does not match!"
            ];
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'success' => true,
            'message' => "Logout Successfully!"
        ]);
    }


    public function me(Request $request){

        return response()->json(['success'=> true, "data" =>  auth('sanctum')->user()]);
    }

}

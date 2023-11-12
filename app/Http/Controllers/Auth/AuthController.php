<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\UserResource;

class AuthController extends BaseController
{

    public function createRegister(Request $request)
    {

        try {
            $validate = Validator::make($request->all(),[
                'fullname' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);
            if($validate->fails()){
                return $this->sendError($validate->errors());
            }
            $path = '';
            if ($request->file()) {
                $fileName = time() . '_' . $request->profile_img->getClientOriginalName();
                $filePath = $request->file('profile_img')->storeAs('LOIHENG', $fileName, 'public');
                $path = '/storage/' . $filePath;
            }
            $check = User::where('email', $request->email)->first();
            if($check){
                if($check->is_verified == 0){
                    User::where('id', $check->id)->update([
                        'fullname' => $request->fullname,
                        'dob' => $request->dob,
                        'gender' => $request->gender,
                        'profile_img' => $path,
                        'dob' => Carbon::parse($request->dob),
                        'verify_code'=> rand(10000, 99999),
                        'password'=>Hash::make($request->password),
                    ]);

                    $newUser = User::where('id', $check->id)->first();
                    Mail::to($newUser->email)->send(new VerifyEmail($newUser));
                    return $this->sendMessageResponse('Register successfully');
                }
                return $this->sendErrorMessageResponse(['email' =>['Email already taken!']]);
            }else{

            $user = User::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'is_active' => $request->is_active,
                'last_login' => $request->last_login,
                'role' => $request->role,
                'status' => $request->status,
                'dob' => Carbon::parse($request->dob),
                'gender' => $request->gender,
                'profile_img' => $path,
                'provider' => $request->provider,
                'provider_id' => $request->provider_id,
                'provider_token' => $request->provider_token,
                'password'=>Hash::make($request->password),
                'verify_code'=> rand(10000, 99999),
                'is_verified'=> false,
            ]);

            Mail::to($user->email)->send(new VerifyEmail($user));

            return response()->json([
                'success' => true,
                'data'   => User::orderBy('id', 'desc')->first(),
                'message' => 'User created successfully!',
                'status' => Response::HTTP_CREATED,
            ], Response::HTTP_CREATED);
        }


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

        $checkUser = User::where('email', $request->email)->first();

        if($checkUser->is_verified == false){

            return $this->sendErrorMessageResponse('Credentials does not match!');

        }

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
            return $this->sendErrorMessageResponse('Credentials does not match!');
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
        $auth = auth('sanctum')->user();
        $user = UserResource::collection(User::where('id', $auth->id)->get());
        $user = $user->first();
        return $this->sendResponse($user, 'User data getting successfully!');
    }

    public function requestVerifyCode($email){
        $checkUser = User::where('email', $email)->first();
        if($checkUser){
            $user = User::where('id', $checkUser->id)->update([
                'verify_code'=> rand(10000, 99999),
            ]);
            $newUser = User::where('id', $checkUser->id)->first();
            Mail::to($newUser->email)->send(new VerifyEmail($newUser));
            return response()->json(['success'=> true, "data" =>  auth('sanctum')->user()]);

        }else{
            return $this->sendErrorMessageResponse('Email not found!');
        }
    }

    public function verifyEmail(Request $request){
        $validate = Validator::make($request->all(),[
            'email' => 'required',
            'code' => 'required',
        ]);
        if($validate->fails()){
            return $this->sendError($validate->errors());
        }
        $checkUser = User::where(['email' => $request->email, 'verify_code' => $request->code])->first();
        if($checkUser){
            $user = User::where('id', $checkUser->id)->update([
                'is_verified'=> 1,
            ]);
            return $this->sendMessageResponse('Successfully verified!');
        }else{
            return $this->sendErrorMessageResponse(['code' =>['Your code is incorrect!']]);
        }
    }

    public function profileUpdate(Request $request){
        $validate = Validator::make($request->all(),[
            "profile_img" => "required||max:3000|mimes:jpeg,png",
        ]);
        if($validate->fails()){
            return $this->sendError($validate->errors());
        }

        $path = '';
        if($request->file()){
            $fileName = time() . '_' . $request->profile_img->getClientOriginalName();
            $filePath = $request->file('profile_img')->storeAs('LOIHENG', $fileName, 'public');
            $path = '/storage/' . $filePath;
        }

        $auth = auth('sanctum')->user();
        User::where('id', $auth->id)->update([
            'profile_img' => $path
        ]);

        return $this->sendMessageResponse(['profile_img' => ['Profile updated']]);
    }
    public function changePassword(Request $request){
        $validate = Validator::make($request->all(),[
            "old_password" => "required",
            "new_password" => "required",
        ]);
        if($validate->fails()){
            return $this->sendError($validate->errors());
        }

        if(!Hash::check($request->old_password, auth('sanctum')->user()->password)){
            return $this->sendErrorMessageResponse(['error' => "Old Password Doesn't match!"]);
        }

        User::whereId(auth('sanctum')->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return $this->sendMessageResponse(['success' => 'Password updated successfully!']);
    }

}

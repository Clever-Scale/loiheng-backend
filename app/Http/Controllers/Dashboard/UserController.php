<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        if (session('user-delete')) {
            toast(Session::get('user-delete'), "success");
        }
        if (session('user-edit')) {
            toast(Session::get('user-edit'), "success");
        }
        $users = User::where('is_admin', '=', 'admin')->get();
        return view('dashboard.users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findorFail($id);

        return view('dashboard.users.edit', compact('user'));

    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate($request, [
            'fullname' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user)],
        ]);


        // dd($request->role_id);
        $pathEmp = $request->file('profile_img');
        $path= User::where('id', $id)->value('profile_img');
        if($pathEmp){
            if ($request->file()) {
                $fileName = time() . '_' . $request->profile_img->getClientOriginalName();
                $filePath = $request->file('profile_img')->storeAs('User', $fileName, 'public');
                $path = '/storage/' . $filePath;
            }
        }

        $record = User::find($id);
        $password = $record->password;
        if ($request->password) {
            $password = Hash::make($request->password);
        }

        User::where('id', $id)->update([
            'fullname' => $request->fullname,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'is_admin' => $request->is_admin,
                'is_active' => $request->is_active,
                'last_login' => $request->last_login,
                'role' => $request->role,
                'status' => $request->status,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'profile_img' => $path,
                'provider' => $request->provider,
                'provider_id' => $request->provider_id,
                'provider_token' => $request->provider_token,
                'password'=>$password,
        ]);
        return redirect()->route('user')->with('user-edit', "User has been edited successfully!");
    }



    public function delete($id)
    {
        User::find($id)->delete();
        return redirect()->route('user')->with('user-delete', 'User has been deleted successfully!');
    }
}

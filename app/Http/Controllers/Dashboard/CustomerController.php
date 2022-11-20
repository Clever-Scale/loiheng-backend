<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function index()
    {
        if (session('customer-delete')) {
            toast(Session::get('customer-delete'), "success");
        }
        if (session('customer-edit')) {
            toast(Session::get('customer-edit'), "success");
        }
        $customers = User::where('is_admin', '=', 'user')->get();
        return view('dashboard.customers.index', compact('customers'));
    }

    public function edit($id)
    {
        $customer = User::findorFail($id);

        return view('dashboard.customers.edit', compact('customer'));

    }
    public function update(Request $request, $id)
    {
        $customer = User::find($id);
        $this->validate($request, [
            'fullname' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($customer)],
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
        return redirect()->route('customer')->with('customer-edit', "Customer has been edited successfully!");
    }



    public function delete($id)
    {
        User::find($id)->delete();
        return redirect()->route('customer')->with('customer-delete', 'Customer has been deleted successfully!');
    }
}

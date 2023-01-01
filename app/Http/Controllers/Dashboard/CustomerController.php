<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index()
    {
        if (session('customer-created')) {
            toast(Session::get('customer-created'), "success");
        }
        if (session('customer-delete')) {
            toast(Session::get('customer-delete'), "success");
        }
        if (session('customer-edit')) {
            toast(Session::get('customer-edit'), "success");
        }
        $customers = User::where('is_admin', '=', 'user')->get();
        return view('dashboard.customers.index', compact('customers'));
    }

    public function getCustomerList(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('is_admin', '!=', 'admin')->select('*');
            return DataTables::of($data)
                    ->addColumn('profile_img', function ($row) {
                        $url = asset($row->profile_img ? $row->profile_img : "assets/img/pp.jpg");
                        return '<img src="' . $url . '"
                    alt="Profile Image" style="width: 60px; height: 60px; border-radius: 4px;">';
                    })
                    ->addColumn('created_at', function ($row) {
                        return '
                        <div class="d-flex ">
                        <div>
                            <i class="bi bi-calendar-date mx-2"></i>
                        </div>
                            <div class="px-2 ">
                                ' . Carbon::create($row->created_at)->toFormattedDateString() .
                            '</div>
                        </div>';
                    })
                    ->addColumn('action', function ($row) {
                        return '
                        <div class="dropdown">
                            <button class="btn" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu p-4">
                                <li>
                                    <a href="' . route("customer.edit", ["id" => $row->id]) . '" class="btn btn-primary btn-sm mb-2" style="width:100%">
                                   Edit
                                    </a>
                                </li>
                                <li>
                                    <form method="post" action="' . route("customer.delete", ["id" => $row->id]) . ' "
                                    id="from1" data-flag="0">
                                    ' . csrf_field() . '<input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm delete"
                                                style="width: 100%">Delete</button>
                                        </form>
                                </li>
                            </ul>
                        </div>';
                    })
                    // ->filter(function ($instance) use ($request) {
                    //     if (!empty($request->get('fullname'))) {
                    //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                    //             return Str::contains(Str::lower($row['fullname']), $request->get('fullname')) ? true : false;
                    //         });
                    //     }
                    //     if (!empty($request->get('email'))) {
                    //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                    //             return Str::contains(Str::lower($row['email']), $request->get('email')) ? true : false;
                    //         });
                    //     }
                    //     if($request->has('from_date')){
                    //         $from_date = Carbon::parse($request->get('from_date'))->format('Y-m-d');
                    //         $to_date = Carbon::parse($request->get('to_date'))->format('Y-m-d');
                    //         $start_date = $from_date != null ? "$from_date 00:00:00" : null;
                    //         $end_date = $to_date != null ? "$to_date 23:59:59" : null;
                    //         $instance = $instance->whereBetween('created_at', [$start_date, $end_date]);

                    //     }
                    //     if (!empty($request->get('search'))) {
                    //         $instance->where('fullname', 'Like', "%{$request->get('search')}%")
                    //         ->orWhere('email', 'Like', "%{$request->get('search')}%")
                    //         ->orWhere('phone_no', 'Like', "%{$request->get('search')}%")
                    //         ;
                    //     }
                    // })
                    ->rawColumns(['created_at', 'action', 'profile_img'  ])
                    ->make(true);
        }
    }

    public function create()
    {
        return view('dashboard.customers.create');
    }
    public function save(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'fullname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);


        // dd($request->role_id);
        $password = Hash::make($request->password);
        $path = '';
        if ($request->file()) {
            $fileName = time() . '_' . $request->profile_img->getClientOriginalName();
            $filePath = $request->file('profile_img')->storeAs('User', $fileName, 'public');
            $path = '/storage/' . $filePath;
        }

        User::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'password'=>$password,
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
        ]);
        return redirect()->route('customer')->with('customer-edit', "Customer has been created successfully!");
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

    public function search(Request $request)
    {
        // dd($request->all());
        if ($request->isMethod('get')) {
            $customers = User::query();
            $from = Carbon::parse($request->get('from'))->format('Y-m-d');
            $to = Carbon::parse($request->get('to'))->format('Y-m-d');
            $start_date = $from != null ? "$from 00:00:00" : null;
            $end_date = $to != null ? "$to 23:59:59" : null;
            $name = $request->get('name');
            $email = $request->get('email');
            if($request->has('from')){
                if (isset($start_date) && isset($end_date)) {
                    $customers = $customers->whereBetween('created_at', [$start_date, $end_date]);
                }
            }
            if (isset($name)){
                $customers = $customers->where('fullname', 'like', '%'.$name.'%');
            }
            if (isset($email)){
                $customers = $customers->where('email','=', $email);
            }

            $customers = $customers->where('is_admin', '!=', 'admin')->orderBy('id', 'desc')->get();
            return view('dashboard.customers.filter' , compact('customers'));
        }
    }
}

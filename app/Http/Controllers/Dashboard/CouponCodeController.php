<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\CouponCode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\CouponForCustomer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class CouponCodeController extends Controller
{
    public function index()
    {
        if (session('success')) {
            toast(Session::get('success'), "success");
        }
        return view('dashboard.coupon-code.index');
    }

    public function create()
    {
        $users = User::where('is_admin', 'user')->get();
        // dd($users);

        return view('dashboard.coupon-code.create', compact('users'));
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'expired_date' => 'required',
            'count' => 'required',
            'value' => 'required',
            'type' => 'required',
            ],[
                "expired_date.required" => "Please select expired date!",
                "type.required" => "Please select type!",
            ]);
        $user = Auth::user();
        if(isset($request->is_customer) ){
            $is_customer = true;
        }else{
            $is_customer = false;
        }
        $coupon = CouponCode::create([
            'code' => $this->generateCouponCode(),
            'expired_date' => $request->expired_date,
            'count' => $request->count,
            'value' => $request->value,
            'type' => $request->type,
            'is_customer' => $is_customer,
            'note' => $request->note,
            'created_by' => $user->id
        ]);

        if($is_customer == true && $coupon){
            $count_user = count($request->user_id);
            if($count_user > 0){
                for ($i=0; $i < $count_user; $i++) {
                    CouponForCustomer::create([
                        'coupon_code_id' => $coupon->id,
                        'customer_id' => $request->user_id[$i]
                    ]);
                }
            }

        }

        return redirect()->route('coupon-code')->with('success', 'Coupon code has been created successfully!');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = CouponCode::orderBy('id', 'desc')->select('*');
            return DataTables::of($data)
                    ->editColumn('created_by', function ($u) {
                        return User::findOrFail($u->created_by)->fullname;
                    })
                    ->addColumn('type', function ($row) {
                        return '
                        <span class="badge text-bg-secondary">'.$row->type.'</span>';
                    })
                    ->addColumn('count', function ($row) {
                        return '
                        <p style="color: green; font-weight: 500">'.$row->count.'</p>';
                    })
                    ->addColumn('is_active', function ($row) {
                        if($row->is_active == true){
                            return '
                        <span class="badge rounded-pill text-bg-success">Active</span>';
                        }else{
                            return '
                            <span class="badge rounded-pill text-bg-danger">Unactive</span>';
                        }

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
                    ->addColumn('value', function ($row) {
                        if($row->type == "percent"){
                            return '<p style="font-weight: 500; color: red">'.$row->value.' %</p>';
                        }else{
                            return '<p style="font-weight: 500; color: red">'.number_format($row->value).' </p>';
                        }
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
                                    <form method="post" action="' . route("coupon-code.delete", ["id" => $row->id]) . ' "
                                    id="from1" data-flag="0">
                                    ' . csrf_field() . '
                                            <button type="submit" class="btn btn-danger btn-sm delete"
                                                style="width: 100%">Delete</button>
                                        </form>
                                </li>
                            </ul>
                        </div>';
                    })
                    ->rawColumns(['created_at', 'action', 'created_by', 'type', 'value', 'count', 'is_active'  ])
                    ->make(true);
        }
    }

    public function generateCouponCode()
    {
        $code = substr(uniqid(), 0, 8);

        $exists = CouponCode::where('code', $code)->count();
        if($exists > 0){
            $this->generateCouponCode();
        }
        return strtoupper('LH-' . $code);
    }

    // public function edit($id)
    // {
    //     $coupon = CouponCode::find($id);
    //     $couponUser = CouponForCustomer::where('coupon_code_id', $id)->get();
    //     $couponUser = json_decode(json_encode($couponUser));
    //     $users = User::where('is_admin', 'user')->get();

    //     return view('dashboard.coupon-code.edit', compact('coupon', 'couponUser', 'users'));
    // }

    public function delete($id)
    {
        CouponCode::where('id', $id)->update([
            'is_active' => false
        ]);

        CouponForCustomer::where('coupon_code_id', $id)->update([
            'is_active' => false
        ]);

        return redirect()->route('coupon-code')->with('success', 'Coupon code disable successfully!');
    }
}

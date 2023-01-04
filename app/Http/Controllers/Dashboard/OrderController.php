<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index()
    {
        return view('dashboard.orders.index');
    }

    public function getOrderList(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::select('*');
            return DataTables::of($data)
                    ->editColumn('user_id', function ($user) {
                        return User::findOrFail( $user->user_id)->fullname;
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
                    ->addColumn('status', function ($row) {
                        switch ($row->status) {
                            case 'confirm':
                                return '<span class="badge rounded-pill text-bg-warning">'.$row->status.'</span>';
                                break;
                            case 'ontheway':
                                return '<span class="badge rounded-pill text-bg-info">'.$row->status.'</span>';
                                break;
                            case 'complete':
                                return '<span class="badge rounded-pill text-bg-success">'.$row->status.'</span>';
                                break;
                            default:
                                return '<span class="badge rounded-pill text-bg-primary">'.$row->status.'</span>';
                                break;
                        }

                    })
                    ->addColumn('total_price', function ($row) {
                        return '<p style="font-size: 18px; color: green; font-weight: 600;">' . $row->total_price . ' $</p>';
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
                                    <a href="' . route("orders.show", ["id" => $row->id]) . '" class="btn btn-success btn-sm mb-2" style="width:100%">
                                        Show
                                    </a>
                                </li>
                            </ul>
                        </div>';
                    })
                    ->filter(function ($instance) use ($request) {
                        if($request->has('from_date')){
                            $from_date = Carbon::parse($request->get('from_date'))->format('Y-m-d');
                            $to_date = Carbon::parse($request->get('to_date'))->format('Y-m-d');
                            $start_date = $from_date != null ? "$from_date 00:00:00" : null;
                            $end_date = $to_date != null ? "$to_date 23:59:59" : null;
                            $instance = $instance->whereBetween('created_at', [$start_date, $end_date]);

                        }
                    })
                    ->rawColumns(['created_at', 'total_price', 'action', 'status' ])
                    ->make(true);
        }
    }

    public function show($id)
    {
        $order = OrderResource::collection(Order::where('id', $id)->get());
        $order = json_decode(json_encode($order->first()));
        // dd($order);

        return view('dashboard.orders.show', compact('order'));
    }

    public function statusChange($id, Request $request)
    {
       Order::find($id)->update([
        'status' => $request->status,
       ]);
    }
}

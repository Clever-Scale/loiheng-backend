<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class PromotionController extends Controller
{
    public function index()
    {
        if (session('create-promotion')) {
            toast(Session::get('create-promotion'), "success");
        }
        $promotion = Promotion::get();
        return view('dashboard.promotion.index', compact('promotion'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Promotion::select('*');
            return DataTables::of($data)
                    ->editColumn('user_id', function ($u) {
                        return User::findOrFail($u->user_id)->fullname;
                    })
                    ->addColumn('product_id', function ($p) {
                        $pname = Product::findOrFail($p->product_id)->name;
                        return '
                        <a  data-bs-toggle="tooltip" data-bs-placement="top" title="'.$pname.'">
                            <p style="overflow: hidden; width: 150px; white-space: nowrap; text-overflow: ellipsis" >'.$pname.'</p>
                        </a>';
                    })
                    ->addColumn('product_img', function ($row) {
                        $pro_img = Product::findOrFail($row->product_id)->cover_img;
                        $url = asset($pro_img ? $pro_img : "assets/img/pp.jpg");
                        return '<img src="' . $url . '"
                    alt="Profile Image" style="width: 60px; height: 60px; border-radius: 4px;">';
                    })
                    ->addColumn('price', function ($row) {
                        $price = Product::findOrFail($row->product_id)->price;
                        return '<p>'.$price.'</p>';
                    })
                    ->addColumn('promo_price', function ($row) {
                        $price = Product::findOrFail($row->product_id)->price;
                        $promo_price =  $row->percent / 100 * $price;
                        $promo_price = $price - $promo_price;
                        return '<p>'.$promo_price.'</p>';
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
                                    <button type="button" class="btn btn-warning btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal'.$row->id.'"  style="width:100%">
                                        Edit
                                    </button>
                                </li>
                                <li>
                                    <form method="post" action="' . route("promo.delete", ["id" => $row->id]) . ' "
                                    id="from1" data-flag="0">
                                    ' . csrf_field() . '<input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm delete"
                                                style="width: 100%">Delete</button>
                                        </form>
                                </li>
                            </ul>
                        </div>';
                    })
                    ->rawColumns(['created_at', 'action', 'product_img', 'promo_price', 'price', 'product_id'  ])
                    ->make(true);
        }
    }

    public function update(Request $request, $id)
    {
        Promotion::where('id', $id)->update([
            'name' => $request->name,
            'percent' => $request->percent,
            'expired_date' => $request->expired_date,
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,

        ]);

        return redirect()->route('promo.index')->with('create-promotion', 'Product promotion updated successfully!');
    }

    public function delete($id)
    {
        Promotion::find($id)->delete();
        return redirect()->route('promo.index')->with('delete-promotion', 'Product promotion deleted successfully!');

    }
}

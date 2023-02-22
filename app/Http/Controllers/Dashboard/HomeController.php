<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;

class HomeController extends Controller
{
    public function index()
    {
        $orders = json_decode(json_encode(OrderResource::collection(Order::paginate(10))));
        $order_count = Order::count();
        $product_count = Product::count();
        $customer_count = User::where('is_admin', 0)->count();
        $products = ProductResource::collection(Product::where('is_active', true)->orderBy('id', 'desc')->paginate(5));
        $products = json_decode(json_encode($products));
        // dd($products);
        // dd(json_decode(json_encode($orders)));
        return view('dashboard.home.index', compact('orders', 'order_count', 'product_count', 'customer_count', 'products'));
    }
}

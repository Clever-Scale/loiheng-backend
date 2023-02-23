<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Cart;
use App\Models\Order;
use App\Mail\OrderMail;
use App\Models\Address;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Delivery;
use App\Models\Promotion;
use App\Models\CouponCode;
use Illuminate\Http\Request;
use App\Models\CouponForCustomer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;

class OrderController extends BaseController
{
    public function getByUserIdOrder()
    {
        try{
            $user = auth('sanctum')->user();
            $orders =  OrderResource::collection(Order::where('user_id', $user->id)->orderBy('id', 'desc')->get());
            return $this->sendResponse($orders,"Order data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }

    }

    public function createOrder(Request $request)
    {
        try{
            $user = auth('sanctum')->user();
            // Re check coupon code start //
            if(isset($request->coupon_code)){
                $code = DB::table('coupon_codes')->where('code', $request->coupon_code)->first();
                $this->checkCouponCode($code, $user->id);
            }
            // Re check coupon code start //

            if($request->product_id){
                $cart = Cart::create([
                    "user_id" => $user->id
                ]);
                $cart_id = $cart->id;
                $net_price = DB::table('products')->where('id', $request->product_id)->first();
                $now = date('Y-m-d');
                $discount = DB::table('promotions')->where('product_id', $request->product_id)->where('expired_date', '>=', $now)->first();
                $cart_data = CartItem::create([
                    'product_id' => $request->product_id,
                    'cart_id' => $cart_id,
                    'qty' => $request->qty,
                    'net_price' => $net_price->price,
                    'discount' => $discount ? $discount->percent : "",
                ]);
                $cart_data = CartResource::collection(Cart::where('id', $cart->id)->where('user_id', $user->id)->get());
                $cart_data = $cart_data->first();
                $cart_data = json_decode(json_encode($cart_data));
            }else{
                $cart_data = CartResource::collection(Cart::where('is_active', 1)->where('user_id', $user->id)->get());
                $cart_data = $cart_data->first();
                $cart_data = json_decode(json_encode($cart_data));
                $cart_id = $cart_data->id;
            }
            $address_id = "";
            if($request->address_id == 0){
                $address_id = $this->newAddress($user->id, $request->full_name, $request->phone,  $request->city, $request->township, $request->region, $request->address_type, $request->street_address);
            }else{
                $address_id = $request->address_id;
            }

            $delivery_fee = DB::table('deliveries')->where('id',$request->delivery_id)->first();
            $coupon_price = 0;
            if(isset($request->coupon_code)){
                $code = DB::table('coupon_codes')->where('code', $request->coupon_code)->first();
                if($code->type == "percent"){
                    $coupon_price =  $code->value / 100 * $cart_data->subtotal;
                }else if($code->type == "amount"){
                    $coupon_price = $code->value;
                }
                $total_price = $cart_data->subtotal - $coupon_price;
            }else{
                $total_price = $cart_data->subtotal;
            }

            if($delivery_fee){
                $total_price = $total_price + $delivery_fee->fee;
            }



            $order = Order::create([
                'user_id' => $user->id,
                'cart_id' => $cart_id,
                'address_id' => $address_id,
                'delivery_id' => $request->delivery_id,
                'payment_method' => $request->payment_method,
                'coupon_code' => $request->coupon_code,
                'coupon_price' => $coupon_price ? $coupon_price : 0,
                'total_price' => $total_price,
                'delivery_fee' => $delivery_fee->fee ? $delivery_fee->fee  : "",
                'order_no' => $this->generateOrderCode(),
            ]);

            $orderdetail = OrderResource::collection(Order::where('id', $order->id)->get());
            $orderdetail = $orderdetail->first();

        //    return $order;

            if($order){
                $cart = Cart::where('user_id', $user->id)->where('id', $order->cart->id)->update([
                    'is_active' => false
                ]);

                $cartItem = DB::table('cart_items')->where('cart_id', $cart_data->id)->get();
                foreach($cartItem as $cat){
                    $stock = DB::table('products')->where('id', $cat->product_id)->value('stock');
                    Product::where('id', $cat->product_id)->update([
                        'stock' => $stock - $cat->qty
                    ]);
                }
                Mail::to($user->email)->send(new OrderMail($orderdetail));

            }

            if($order && isset($request->coupon_code)){
                $coup_code = DB::table('coupon_codes')->where('code', $request->coupon_code)->first();
                CouponCode::where('id', $coup_code->id)->update([
                    'count' => $coup_code->count - 1
                ]);
                if($coup_code->is_customer == true){
                    CouponForCustomer::where('coupon_code_id', $coup_code->id)->where('customer_id', $user->id)->update([
                        'is_active' => false
                    ]);
                }
            }
            return $this->sendResponse($order,"Order successfully!.");
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function generateOrderCode()
    {
        $order_code = DB::table('orders')->orderBy('id', 'DESC')->pluck('id')->first();
        if ($order_code == null or $order_code == "") {
            #If Table is Empty
            $num = 1;
            $order_code = sprintf('%04d',$num);
        } else {
            #If Table has Already some Data

            $num = $order_code + 1;
            $order_code =sprintf('%04d',$num);
        }
        $order_no = 'LH-' . $order_code;

        return $order_no;
    }

    public function newAddress($userId, $full_name, $phone, $city, $township, $region, $address_type, $street_address)
    {
        $address = Address::create([
            'user_id' => $userId,
            'full_name' => $full_name,
            'phone' => $phone,
            'city' => $city,
            'township' => $township,
            'region' => $region,
            'address_type' => $address_type,
            'street_address' => $street_address,
        ]);

        return $address->id;
    }

    public function checkCouponCode($code, $userId)
    {
        if($code){
            if($code->is_customer == true){
                $customer_code = CouponForCustomer::where('coupon_code_id', $code->id)->where('customer_id', $userId)->first();
                if(is_null($customer_code)){
                    return $this->sendErrorMessageResponse("You can't use this coupon code!");
                }else if($customer_code->is_active == false){
                    return $this->sendErrorMessageResponse("You code is already used!");
                }
            }
            if($code->is_active == false){
                return $this->sendErrorMessageResponse('Your code is invalid!');
            }
            if($code->expired_date < date('Y-m-d')){
                return $this->sendErrorMessageResponse('Your code is expired!');
            }
            if($code->count <= 0){
                return $this->sendErrorMessageResponse('Your code reach at limit!');
            }
        }else{
            return $this->sendErrorMessageResponse('Your code is invalid!');
        }
    }

}

<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;

class OrderController extends BaseController
{
    public function getByUserIdOrder()
    {
        try{
            $user = auth('sanctum')->user();
            $orders =  OrderResource::collection(Order::where('user_id', $user->id)->get());
            return $this->sendResponse($orders,"Order data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }

    }

    public function createOrder(Request $request)
    {
        try{
            $user = auth('sanctum')->user();
            $address_id = "";
            if($request->address_id == 0){
                $address = Address::create([
                    'user_id' => $user->id,
                    'full_name' => $request->full_name,
                    'phone' => $request->phone,
                    'city' => $request->city,
                    'township' => $request->township,
                    'region' => $request->region,
                    'address_type' => $request->address_type,
                    'street_address' => $request->street_address,
                ]);
                $address_id = $address->id;
            }else{
                $address_id = $request->address_id;
            }
            $order_code = Order::orderBy('id', 'DESC')->pluck('id')->first();
            if ($order_code == null or $order_code == "") {
                #If Table is Empty
                $num = 1;
                $order_code = sprintf('%04d',$num);
            } else {
                #If Table has Already some Data

                $num = $order_code + 1;
                $order_code =sprintf('%04d',$num);
            }
            $order_no = 'LH' . $order_code;
            if(isset($request->coupon_price)){
                $total_price = $request->subtotal - $request->coupon_price;
            }else{
                $total_price = $request->subtotal;
            }
            $order = Order::create([
                'user_id' => $user->id,
                'cart_id' => $request->cart_id,
                'address_id' => $address_id,
                'delivery_id' => $request->delivery_id,
                'payment_method' => $request->payment_method,
                'coupon_code' => $request->coupon_code,
                'coupon_price' => $request->coupon_price,
                'total_price' => $total_price,
                'order_no' => $order_no,
            ]);

            if($order){
                $cart = Cart::where('user_id', $user->id)->where('id', $order->cart_id)->update([
                    'is_active' => false
                ]);
            }
            return $this->sendResponse($order,"Order successfully!.");
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;
use App\Mail\OrderMail;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;

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
            $cart_data = CartResource::collection(Cart::where('is_active', 1)->where('user_id', $user->id)->get());
            $cart_data = $cart_data->first();
            $cart_data = json_decode(json_encode($cart_data));
            $cart_id = $cart_data->id;
            if($request->product_id){
                $cart = Cart::create([
                    "user_id" => $user->id
                ]);
                $cart_id = $cart->id;

                $cart_data = CartItem::create([
                    'product_id' => $request->product_id,
                    'cart_id' => $cart_id,
                    'qty' => $request->qty,
                ]);
                $cart_data = CartResource::collection(Cart::where('id', $cart->id)->where('user_id', $user->id)->get());
                $cart_data = $cart_data->first();
                $cart_data = json_decode(json_encode($cart_data));
            }
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
            $order_no = 'LH-' . $order_code;
            if(isset($request->coupon_price)){
                $total_price = $cart_data->subtotal - $request->coupon_price;
            }else{
                $total_price = $cart_data->subtotal;
            }
            $order = Order::create([
                'user_id' => $user->id,
                'cart_id' => $cart_id,
                'address_id' => $address_id,
                'delivery_id' => $request->delivery_id,
                'payment_method' => $request->payment_method,
                'coupon_code' => $request->coupon_code,
                'coupon_price' => $request->coupon_price,
                'total_price' => $total_price,
                'order_no' => $order_no,
            ]);

            $orderdetail = OrderResource::collection(Order::where('id', $order->id)->get());
            $orderdetail = $orderdetail->first();

        //    return $order;

            if($order){
                $cart = Cart::where('user_id', $user->id)->where('id', $order->cart->id)->update([
                    'is_active' => false
                ]);

                $cartItem = CartItem::where('cart_id', $cart_data->id)->get();
                foreach($cartItem as $cat){
                    $stock = Product::where('id', $cat->product_id)->value('stock');
                    Product::where('id', $cat->product_id)->update([
                        'stock' => $stock - $cat->qty
                    ]);
                }
                Mail::to($user->email)->send(new OrderMail($orderdetail));

            }
            return $this->sendResponse($order,"Order successfully!.");
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

}

<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartCollection;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Promotion;

class CartController extends BaseController
{
    public function getByUserIdCart(Request $request)
    {
        try{
            $user = auth('sanctum')->user();
            $carts =  CartResource::collection(Cart::where('user_id', $user->id)->where('is_active', true)->get());
            // $carts = json_decode(json_encode($carts));
            return $this->sendResponse($carts,"Cart data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function createCart(Request $request)
    {
        try{
            $user = auth('sanctum')->user();
            $cart = Cart::where('user_id', $user->id)->where('is_active', true)->first();
            if(is_null($cart) || $cart->is_active != true){
                $cart = Cart::create([
                    'user_id' => $user->id
                ]);
            }
            $old_cart_id = CartItem::where('cart_id', $cart->id)->where('product_id', $request->product_id)->value('id');
            $old_qty = CartItem::where('cart_id', $cart->id)->where('product_id', $request->product_id)->value('qty');
            $net_price = Product::where('id', $request->product_id)->first();
            $now = date('Y-m-d');
            $discount = Promotion::where('product_id', $request->product_id)->where('expired_date', '>=', $now)->first();
            if($old_cart_id){
                if(is_null($request->qty)){
                    $old_qty =  $old_qty + 1;
                }else{
                    $old_qty = $request->qty;
                }
                CartItem::where('id', $old_cart_id)->update([
                    'product_id' => $request->product_id,
                    'cart_id' => $cart->id,
                    'qty' => $old_qty,
                    'net_price' => $net_price->price,
                    'discount' => $discount ? $discount->percent : "",
                ]);
                $cartData =  CartResource::collection(Cart::where('id', $cart->id)->get());
            }else{
                if(is_null($request->qty)){
                    $qty =  1;
                }else{
                    $qty = $request->qty;
                }
                CartItem::create([
                    'product_id' => $request->product_id,
                    'cart_id' => $cart->id,
                    'qty' => $qty,
                    'net_price' => $net_price->price,
                    'discount' => $discount ? $discount->percent : "",
                ]);
                $cartData =  CartResource::collection(Cart::where('id', $cart->id)->get());

            }

            // $old_cartId = Cart::where('is_active', true)->where('user_id', $user->id)->where('product_id', $request->product_id)->value('id');
            // if($old_cartId){
            //     $old_qty = Cart::where('is_active', true)->where('user_id', $user->id)->where('product_id', $request->product_id)->value('qty');
            //     $new_qty = $old_qty + 1;
            //      Cart::where('id', $old_cartId)->update([
            //         'user_id' => $user->id,
            //         'product_id' => $request->product_id,
            //         'status' => $request->status,
            //         'qty' => $new_qty
            //     ]);
            //     $cart = CartResource::collection(Cart::where('id', $old_cartId)->get());
            // }else{
            //     $qty = 1;
            //     $cart = Cart::create([
            //         'user_id' => $user->id,
            //         'product_id' => $request->product_id,
            //         'status' => $request->status,
            //         'qty' => $qty
            //     ]);
            //     $cart = CartResource::collection(Cart::where('id', $cart->id)->get());
            // }
            return $this->sendResponse($cartData ,"Cart Added successfully!.");
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function removeCartItem($id)
    {
        try{
            $user = auth('sanctum')->user();
            $user_cart = Cart::where('user_id', $user->id)->where('is_active', true)->first();
            if(!is_null($user_cart)){
                CartItem::where('id', $id)->delete();
                return $this->sendMessageResponse("Cart Item removed successfully!.");
            }else{
                return $this->sendErrorMessageResponse('Cart item is not have!');
            }
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function increaseCart(Request $request, $id)
    {
        try{
            $user = auth('sanctum')->user();
            $user_cart = Cart::where('user_id', $user->id)->where('is_active', true)->first();
            if(!is_null($user_cart)){
                $old_qty = CartItem::where('id', $id)->value('qty');
                if(is_null($request->qty)){
                    $old_qty =  $old_qty + 1;
                }else{
                    $old_qty = $request->qty;
                }
                CartItem::findOrFail($id)->update([
                    'qty' => $old_qty,
                ]);
                return $this->sendMessageResponse("Increased successfully!.");
            }else{
                return $this->sendErrorMessageResponse('something went wrong!');
            }
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    public function descreaseCart(Request $request, $id)
    {
        try{
            $user = auth('sanctum')->user();
            $user_cart = Cart::where('user_id', $user->id)->where('is_active', true)->first();
            if(!is_null($user_cart)){
                $old_qty = CartItem::where('id', $id)->value('qty');
                if(is_null($request->qty)){
                    $old_qty = $old_qty - 1;
                }else{
                    $old_qty = $request->qty;
                }
                if($old_qty <= 0){
                    CartItem::findOrFail($id)->update([
                        'qty' => 0,
                    ]);
                }else{
                    CartItem::findOrFail($id)->update([
                        'qty' => $old_qty,
                    ]);
                }
                return $this->sendMessageResponse("Descreased successfully!.");
            }else{
                return $this->sendErrorMessageResponse('something went wrong!');
            }
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}

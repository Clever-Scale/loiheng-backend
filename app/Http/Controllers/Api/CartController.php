<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartCollection;

class CartController extends BaseController
{
    public function getByUserIdCart()
    {
        try{
            $user = auth('sanctum')->user();
            $carts = new CartCollection(Cart::where('user_id', $user->id)->where('is_active', true)->paginate(10));
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
            $old_cartId = Cart::where('user_id', $user->id)->where('product_id', $request->product_id)->value('id');
            if($old_cartId){
                $old_qty = Cart::where('user_id', $user->id)->where('product_id', $request->product_id)->value('qty');
                $new_qty = $old_qty + 1;
                Cart::where('id', $old_cartId)->update([
                    'user_id' => $request->user_id,
                    'product_id' => $request->product_id,
                    'status' => $request->status,
                    'qty' => $new_qty
                ]);
            }else{
                $qty = 1;
                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $request->product_id,
                    'status' => $request->status,
                    'qty' => $qty
                ]);
            }
            return $this->sendMessageResponse("Cart Added successfully!.");
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function removeCartItem($id)
    {
        try{
            $user = auth('sanctum')->user();
            $old = Cart::where('user_id', $user->id)->where('id', $id)->value('id');
            if($old != null){
                Cart::findOrFail($id)->update([
                    'is_active' => false,
                ]);
                return $this->sendMessageResponse("Cart removed successfully!.");
            }else{
                return $this->sendErrorMessageResponse('something went wrong!');
            }
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartCollection;

class CartController extends BaseController
{
    public function getByUserIdCart($id)
    {
        try{
            $carts = new CartCollection(Cart::where('user_id', $id)->paginate(10));
            // $carts = json_decode(json_encode($carts));
            return $this->sendResponse($carts,"Cart data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function createCart(Request $request)
    {
        try{
            $order = Cart::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'status' => $request->status,
            ]);
            return $this->sendResponse($order,"Cart Added successfully!.");
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function removeCartItem($id)
    {
        try{
            Cart::findOrFail($id)->update([
                'is_active' => false,
            ]);
            return $this->sendMessageResponse("Cart removed successfully!.");
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}

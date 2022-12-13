<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WishlistCollection;

class WishlistController extends BaseController
{
    public function getByUserIdWishlist()
    {
        try{
            $user = auth('sanctum')->user();
            $wishlist = new WishlistCollection(Wishlist::where('user_id', $user->id)->paginate(10));
            // $carts = json_decode(json_encode($carts));
            return $this->sendResponse($wishlist,"Wishlist data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    public function creteWishlist(Request $request)
    {
        try{
            $user = auth('sanctum')->user();
            $old_whishlist = Wishlist::where('user_id', $user->id)->where('product_id', $request->product_id)->value('id');

            if($old_whishlist){
                return $this->sendMessageResponse('This product already added in your wishlist');
            }else{
                Wishlist::create([
                    'user_id' => $user->id,
                    'product_id' => $request->product_id,
                ]);
                return $this->sendMessageResponse('Product has been added in whishlist successfully!');
            }
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function removeWishlist($id)
    {
        $user = auth('sanctum')->user();
        $old = Wishlist::where('user_id', $user->id)->where('product_id', $id)->value('id');
        if($old != null){
            Wishlist::findOrFail($old)->delete();
            return $this->sendMessageResponse('Product wishlist removed successfully!');
        }else{
            return $this->sendErrorMessageResponse('something went wrong!');
        }
    }
}

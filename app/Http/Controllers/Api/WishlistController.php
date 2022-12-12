<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WishlistCollection;

class WishlistController extends BaseController
{
    public function getByUserIdWishlist($id)
    {
        try{
            $wishlist = new WishlistCollection(Wishlist::where('user_id', $id)->paginate(10));
            // $carts = json_decode(json_encode($carts));
            return $this->sendResponse($wishlist,"Wishlist data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    public function creteWishlist(Request $request)
    {
        try{
            $old_whishlist = Wishlist::where('user_id', $request->user_id)->where('product_id', $request->product_id)->value('id');

            if($old_whishlist){
                return $this->sendMessageResponse('This product already added in your wishlist');
            }else{
                Wishlist::create([
                    'user_id' => $request->user_id,
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
        Wishlist::findOrFail($id)->delete();
        return $this->sendMessageResponse('Product wishlist removed successfully!');
    }
}

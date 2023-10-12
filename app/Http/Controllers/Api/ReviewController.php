<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ReviewController extends BaseController
{
    public function create(Request $request)
    {
        try{
            $validate = Validator::make($request->all(),[
                "product_id" => "required",
                "content" => 'required',
            ]);
            if($validate->fails()){
                return $this->sendError($validate->errors());
            }
            $user = auth('sanctum')->user();
            // return $old_address;
            $reivew = ProductReview::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'star' => $request->star,
                'content' => $request->content,
            ]);
            return $this->sendResponse($reivew,"Review added successfully!.");
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}

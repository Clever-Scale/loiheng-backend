<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\PromotionCollection;

class PromotionController extends BaseController
{
    public function allPromotions(Request $request)
    {
        $limit = $request->limit;
        try{
            $now = date('Y-m-d');
            $promotion = Promotion::where('expired_date', '>=', $now)->get();

            if(count($promotion) > 0){
                $products = Product::query();
                $products = $products->where(function ($query) use ($promotion)  {
                    $prod_id = [];
                   foreach($promotion as $promo){
                    $prod_id[] = $promo->product_id;
                   }
                    $query->whereIn('id', $prod_id);
                });
                if(isset($request->category_id)){
                    $products = $products->whereHas('category', function ($query)  {
                        $cat_array = explode(',',request('category_id'));
                        $query->whereIn('id', $cat_array);
                    });
                }
                if(isset($request->brand_id)){
                    $products = $products->whereHas('brand', function ($query)  {
                        $brand_array = explode(',',request('brand_id'));
                        $query->whereIn('id', $brand_array);
                    });
                }
                if(isset($request->is_feature_product)){
                    $products = $products->where('is_feature_product', $request->is_feature_product);
                }
                $products = new ProductCollection($products->where('is_active', 1)->where('stock', '>', "0")->paginate($limit));
                return $this->sendResponse($products,"All promotion products data getting successfully!");
            }else{
                $products = [];
                return $this->sendResponse($products,"There is no promotion!");
            }

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}

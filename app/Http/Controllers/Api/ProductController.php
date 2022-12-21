<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Models\Promotion;
use Illuminate\Support\Carbon;
use Psy\CodeCleaner\IssetPass;

class ProductController extends BaseController
{
    public function allProducts(Request $request)
    {
        try{
            $products = Product::query();
            if(isset($request->category_id)){
                if (count($request->category_id) > 0) {
                    for($i=0; $i < count($request->category_id); $i++){
                        $products = $products->orWhere('category_id', $request->category_id[$i]);
                    }
                }
            }
            if(isset($request->brand_id)){
                if (count($request->brand_id) > 0) {
                    for($i=0; $i < count($request->brand_id); $i++){
                        $products = $products->orWhere('brand_id', $request->brand_id[$i]);
                    }
                }
            }
            return $products->get();
            if(isset($request->is_feature_product)){
                $products = $products->where('is_feature_product', $request->is_feature_product);
            }
            $products = new ProductCollection($products->paginate($request->limit));
            return $this->sendResponse($products,"All products data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    public function newArrivals()
    {
        try{
            $new_arrivals = new ProductCollection(Product::where('is_new_arrival', 1)->paginate(10));
            return $this->sendResponse($new_arrivals,"New arrival products data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function featuredProducts()
    {
        try{
            $featured_products = new ProductCollection(Product::where('is_feature_product', 1)->paginate(10));
            return $this->sendResponse($featured_products,"Featured products data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function productDetailById($id)
    {
        try{
            $product_detail = new ProductCollection(Product::where('id',$id)->paginate(10));
            return $this->sendResponse($product_detail,"Product detail data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function productByCategoryId($id)
    {
        try{
            $products = new ProductCollection(Product::where('category_id',$id)->paginate(10));
            return $this->sendResponse($products,"Product data getting by category successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function productByBrandId($id)
    {
        try{
            $products = new ProductCollection(Product::where('brand_id',$id)->paginate(10));
            return $this->sendResponse($products,"Product data getting by brand successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}

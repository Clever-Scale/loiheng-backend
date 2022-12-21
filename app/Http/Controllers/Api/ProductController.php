<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Support\Carbon;
use Psy\CodeCleaner\IssetPass;

class ProductController extends BaseController
{
    public function allProducts(Request $request)
    {
        try{
            $limit = $request->limit;
            $products = Product::query();
            if(isset($request->category_id)){
                $products = $products->whereHas('category', function ($query)  {
                    $query->whereIn('id', request('category_id'));
                });
            }
            if(isset($request->brand_id)){
                $products = $products->whereHas('brand', function ($query)  {
                    $query->whereIn('id', request('brand_id'));
                });
            }
            if(isset($request->is_feature_product)){
                $products = $products->where('is_feature_product', $request->is_feature_product);
            }
            // return $products->get();
            // if($request->price_range){
            //     $products = $products->whereBetween('price', $request->price_range);
            // }
            $products = new ProductCollection($products->paginate($limit));
            return $this->sendResponse($products,"All products data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    public function newArrivals(Request $request)
    {
        try{
            $limit = $request->limit;
            $new_arrivals = new ProductCollection(Product::where('is_new_arrival', 1)->paginate($limit));
            return $this->sendResponse($new_arrivals,"New arrival products data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function featuredProducts(Request $request)
    {
        try{
            $limit = $request->limit;
            $featured_products = new ProductCollection(Product::where('is_feature_product', 1)->paginate($limit));
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

    public function productByCategoryId(Request $request, $id)
    {
        try{
            $limit = $request->limit;
            $products = new ProductCollection(Product::where('category_id',$id)->paginate($limit));
            return $this->sendResponse($products,"Product data getting by category successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function productByBrandId(Request $request, $id)
    {
        try{
            $limit = $request->limit;
            $products = new ProductCollection(Product::where('brand_id',$id)->paginate($limit));
            return $this->sendResponse($products,"Product data getting by brand successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}

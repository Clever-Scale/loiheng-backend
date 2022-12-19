<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Models\Promotion;
use Illuminate\Support\Carbon;

class ProductController extends BaseController
{
    public function allProducts(Request $request)
    {
        try{
            $products = Product::query();
            $category_fields = [];
            $brand_fields = [];
            if (isset($request->category_id)) {
                $category = [
                    "title" => "category_id",
                    "value" => $request->category_id,
                ];
                array_push($category_fields, $category);
            };
            if (isset($request->brand_id)) {
                $brand = [
                    "title" => "brand_id",
                    "value" => $request->brand_id,
                ];
                array_push($brand_fields, $brand);
            };
            if (count($category_fields) > 0) {
                foreach ($category_fields as $cat_field) {
                    $products = $products->where($cat_field['title'], $cat_field['value']);
                }
            }
            if (count($brand_fields) > 0) {
                foreach ($brand_fields as $field) {
                    $products = $products->where($field['title'], $field['value']);
                }
            }
            // if($request->category_id){
            //     $products = $products->where('category_id', $request->category_id);
            // }
            // if($request->brand_id){
            //     $products = $products->where('brand_id', $request->brand_id);
            // }
            if($request->is_feature_product){
                $products = $products->where('is_feature_product', $request->is_feature_product);
            }
            // if($request->price_range){
            //     $products = $products->whereBetween('price', $request->price_range);
            // }
            $products = new ProductCollection($products->paginate(10));
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

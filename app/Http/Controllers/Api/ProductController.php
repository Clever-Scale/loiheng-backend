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
            if(!is_null($request->search)){
                $products = $products->where(function ($query) use  ($request) {
                    $query->orWhere('name', 'LIKE', "%$request->search%");
                    $query->orWhere('sku', 'LIKE', "%$request->search%");
                    $query->orWhere('product_code', 'LIKE', "%$request->search%");
                });
            }
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
            if(isset($request->sort_by)){
                switch ($request->sort_by) {
                    case 'is_feature_product':
                        $products = $products->where('is_feature_product', 1);
                        break;
                    case 'is_new_arrival':
                        $products = $products->where('is_new_arrival', 1);
                        break;
                    case 'highest_price':
                        $products = $products->orderBy('price', 'DESC');
                        break;
                    case 'lowest_price':
                        $products = $products->orderBy('price', 'ASC');
                        break;
                    default:
                        $products = $products;
                        break;
                }

            }
            // return $products->get();
            if($request->start_price_range && $request->end_price_range){
                $products = $products->whereBetween('price', [$request->start_price_range, $request->end_price_range]);
            }
            $products = new ProductCollection($products->where('is_active', 1)->paginate($limit));
            return $this->sendResponse($products,"All products data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    public function newArrivals(Request $request)
    {
        try{
            $limit = $request->limit;
            $new_arrivals = new ProductCollection(Product::where('is_active', 1)->where('is_new_arrival', 1)->paginate($limit));
            return $this->sendResponse($new_arrivals,"New arrival products data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function featuredProducts(Request $request)
    {
        try{
            $limit = $request->limit;
            $featured_products = new ProductCollection(Product::where('is_active', 1)->where('is_feature_product', 1)->paginate($limit));
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

<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class ProductController extends BaseController
{
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
}

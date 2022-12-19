<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandCollection;

class BrandController extends BaseController
{
    //brands
    public function brands(Request $request)
    {
        try{
            $limit = $request->limit;
            $brands = new BrandCollection(Brand::where('is_active', 1)->paginate($limit));
            return $this->sendResponse($brands,"Brands data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}

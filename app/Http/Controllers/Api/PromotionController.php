<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PromotionCollection;

class PromotionController extends BaseController
{
    public function allPromotions(Request $request)
    {
        $limit = $request->limit;
        try{
            $now = date('Y-m-d');
            $products = new PromotionCollection(Promotion::where('expired_date', '>=', $now)->paginate($limit));
            return $this->sendResponse($products,"All promotion products data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}

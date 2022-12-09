<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Delivery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryCollection;

class DeliveryController extends BaseController
{
    public function deliveries()
    {
        try{
            $delivery = new DeliveryCollection(Delivery::paginate(10));
            return $this->sendResponse($delivery,"Delivery data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}

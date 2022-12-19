<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\BannerSlider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BannerSliderCollection;

class BannerSliderController extends BaseController
{
    public function getHomePageSlider(Request $request)
    {
        try{
            $limit = $request->limit;
            $home_banner = new BannerSliderCollection(BannerSlider::paginate($limit));
            return $this->sendResponse($home_banner,"Banner slider image data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;

class CategoryController extends BaseController
{
    public function categories(Request $request)
    {
        try{
            $limit = $request->limit;
            $category = new CategoryCollection(Category::where('is_active', 1)->where('parent', '=', 0)->paginate($limit));
            return $this->sendResponse($category,"Category data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
}

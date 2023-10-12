<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyProfileResource;

class CompanyProfileController extends BaseController
{
    public function getCompanyProfile()
    {
        try{
            $company_profile = CompanyProfileResource::collection(CompanyProfile::get());
            $company_profile = $company_profile->first();
            return $this->sendResponse($company_profile,"Company profile data getting successfully!");

        }catch(Exception $e){
            return $this->sendError($e->getMessage());
        }

    }
}

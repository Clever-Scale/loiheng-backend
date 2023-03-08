<?php

namespace App\Http\Controllers\Api;

use App\Models\CouponCode;
use Illuminate\Http\Request;
use App\Models\CouponUsedUser;
use App\Models\CouponForCustomer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CouponCodeController extends BaseController
{
    public function applyCouponCode($code)
    {

        $code = CouponCode::where('code', $code)->first();
        $auth_user = Auth::user();
        if($code){
            $is_used = CouponUsedUser::where('coupon_id', $code->id)->where('user_id', $auth_user->id)->first();
            if(isset($is_used)){
                return $this->sendErrorMessageResponse('You already used this code!');
            }
            if($code->is_customer == true){
                $customer_code = CouponForCustomer::where('coupon_code_id', $code->id)->where('customer_id', $auth_user->id)->first();
                if(is_null($customer_code)){
                    return $this->sendErrorMessageResponse("You can't use this coupon code!");
                }else if($customer_code->is_active == false){
                    return $this->sendErrorMessageResponse("You code is already used!");
                }
            }
            if($code->is_active == false){
                return $this->sendErrorMessageResponse('Your code is invalid!');
            }
            if($code->expired_date < date('Y-m-d')){
                return $this->sendErrorMessageResponse('Your code is expired!');
            }
            if($code->count <= 0){
                return $this->sendErrorMessageResponse('Your code reach at limit!');
            }
            return $this->sendResponse($code, 'Your code is valid!');
        }else{
            return $this->sendErrorMessageResponse('Your code is invalid!');
        }
    }
}

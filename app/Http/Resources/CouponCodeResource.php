<?php

namespace App\Http\Resources;

use App\Models\CouponUsedUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = Auth::user();
        $is_used = CouponUsedUser::where('coupon_id', $this->id)->where('user_id', $user->id)->first();
        if(isset($is_used)){
            $is_used_coupon = true;
        }else{
            $is_used_coupon = false;
        }
        return [
            'id' => $this->id,
            'code' => $this->code,
            'count' => $this->count,
            'expired_date' => $this->expired_date,
            'value' => $this->value,
            'type' => $this->type,
            'is_customer' => $this->is_customer,
            'note' => $this->note,
            'created_by' => $this->created_by,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'is_used' => $is_used_coupon
        ];
    }
}

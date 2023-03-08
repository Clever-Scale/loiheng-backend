<?php

namespace App\Http\Resources;

use App\Models\CouponCode;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerCouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $coupon = CouponCodeResource::collection(CouponCode::where('id', $this->coupon_code_id)->get());
        $coupon = $coupon->first();

        return [
            'coupon_codes' => $coupon,
            'is_active' => $this->is_active
        ];
    }
}

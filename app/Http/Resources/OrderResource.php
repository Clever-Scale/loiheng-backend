<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user_id,
            'cart' => $this->cart_id,
            'address' => $this->address_id,
            'delivery' => $this->delivery_id,
            'payment_method' => $this->payment_method,
            'coupon_code' => $this->coupon_code,
            'coupon_price' => $this->coupon_price,
            'total_price' => $this->total_price,
            'discount_price' => $this->discount_price,
            'status' => $this->status,
            'order_no' => $this->order_no,
            'delivery_fee' => $this->delivery_fee,
            'is_active' => $this->is_active,
            'is_preorder' => $this->is_preorder,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

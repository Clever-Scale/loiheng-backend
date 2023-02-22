<?php

namespace App\Http\Resources;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Delivery;
use App\Models\User;
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
        $cart = CartResource::collection(Cart::where('id', $this->cart_id)->get());
        $cart = $cart->first();
        return [
            'id' => $this->id,
            'user' => User::where('id', $this->user_id)->first(),
            'cart' => $cart,
            'address' => Address::where('id', $this->address_id)->first(),
            'delivery' => Delivery::where('id', $this->delivery_id)->first(),
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

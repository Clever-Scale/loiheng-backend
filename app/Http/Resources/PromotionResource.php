<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $price = Product::where('id', $this->product_id)->value('price');
        $promo_price =  $this->percent / 100 * $price;
        $promo_price = $price - $promo_price;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'percent' => $this->percent,
            'promo_price' => $promo_price,
            'user' => User::where('id', $this->user_id)->get(),
            'product' => ProductResource::collection(Product::where('id', $this->product_id)->get()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

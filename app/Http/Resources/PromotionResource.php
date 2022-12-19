<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Product;
use App\Models\Setting;
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
        $exchange_rate = Setting::where('key', 'exchange_rate')->value('value');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'percent' => $this->percent,
            'promo_price' => $promo_price * $exchange_rate,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Product;
use App\Models\Setting;
use App\Models\CartItem;
use App\Models\Promotion;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $cart_item = CartItemResource::collection(CartItem::where('cart_id', $this->id)->where('is_active', true)->get());
        $subtotal = 0;
        $exchange_rate = Setting::where('key', 'exchange_rate')->value('value');

        foreach($cart_item as $item){
            $now = date('Y-m-d');
            $promo = Promotion::where('product_id', $item->product->id)->where('expired_date', '>=', $now)->value('percent');
            $exchange_rate = Setting::where('key', 'exchange_rate')->value('value');
            if(!is_null($promo)){
                $t = $item->product->price;
                $promo_price =  $promo / 100 * $t;
                $promo_price = $t - $promo_price;
                $item_price = $promo_price * $item->qty;
            }else{
                $item_price = $item->product->price * $item->qty;
            }
            $subtotal =   $subtotal + $item_price;
        }
        $subtotal = $subtotal * $exchange_rate;
        return [
            'id' => $this->id,
            'user' => User::where('id', $this->user_id)->get(),
            'cart_item' => $cart_item,
            'subtotal' => $subtotal,
            // 'test' => $promo_price,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

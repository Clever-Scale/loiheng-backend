<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Product;
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
        return [
            'id' => $this->id,
            'user' => User::where('id', $this->user_id)->get(),
            'product' => Product::where('id', $this->product_id)->get(),
            'status' => $this->status,
            'is_active' => $this->is_active,
            'is_preorder' => $this->is_preorder,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'sku' => $this->sku,
            'desc_file' => $this->desc_file,
            'approved_by' => $this->approved_by,
            'approved_when' => $this->approved_when,
            'status' => $this->status,
            'is_active' => $this->is_active,
            'is_preorder' => $this->is_preorder,
            'is_feature_product' => $this->is_feature_product,
            'is_new_arrival' => $this->is_new_arrival,
            'user' => User::where('id', $this->user_id)->get(),
            'category' => Category::where('id', $this->category_id)->get(),
            'brand' => Brand::where('id', $this->brand_id)->get(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
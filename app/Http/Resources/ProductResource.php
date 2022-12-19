<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductPicture;
use App\Models\ProductSpec;
use App\Models\ProductWarranty;
use App\Models\Promotion;
use App\Models\Setting;
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
        $exchange_rate = Setting::where('key', 'exchange_rate')->value('value');
        $now = date('Y-m-d');
        return [
            'id' => $this->id,
            'product_code' => $this->product_code,
            'name' => $this->name,
            'price' => $this->price * $exchange_rate,
            'cover_img' => $this->cover_img,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'sku' => $this->sku,
            'stock' => $this->stock,
            'desc_file' => $this->desc_file,
            'approved_by' => $this->approved_by,
            'approved_when' => $this->approved_when,
            'status' => $this->status,
            'is_active' => $this->is_active,
            'is_preorder' => $this->is_preorder,
            'is_feature_product' => $this->is_feature_product,
            'is_new_arrival' => $this->is_new_arrival,
            'created_by' => User::where('id', $this->user_id)->get(),
            'category' => Category::where('id', $this->category_id)->get(),
            'brand' => Brand::where('id', $this->brand_id)->get(),
            'product_specs' => ProductSpec::where('product_id', $this->id)->get(),
            'product_warranties' => ProductWarranty::where('product_id', $this->id)->get(),
            'product_pictures' => ProductPicture::where('product_id', $this->id)->get(),
            'discount' => PromotionResource::collection(Promotion::where('product_id', $this->id)->where('expired_date', '>=', $now)->get()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

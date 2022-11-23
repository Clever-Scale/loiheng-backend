<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'city' => $this->city,
            'township' => $this->township,
            'region' => $this->region,
            'phone' => $this->phone,
            'full_name' => $this->full_name,
            'is_default' => $this->is_default,
            'address_type' => $this->address_type,
            'street_address' => $this->street_address,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

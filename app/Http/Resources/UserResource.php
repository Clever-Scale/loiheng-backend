<?php

namespace App\Http\Resources;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'fullname' => $this->fullname,
            'email' => $this->email,
            'profile_img' => $this->profile_img,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'orderCount' => Order::where('user_id', $this->id)->count(),
            'addressCount' => Address::where('user_id', $this->id)->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

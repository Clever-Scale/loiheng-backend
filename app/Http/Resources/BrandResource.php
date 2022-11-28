<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'picture' => $this->picture,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'created_by' => User::where('id', $this->created_by)->get(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

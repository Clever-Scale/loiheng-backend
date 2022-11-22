<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\OrderResource;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'orders' => OrderResource::collection($this->collection),
            'pagination' => [
                "current_page" => $this->currentPage(),
                "first_page_url" => $this->getOptions()['path'] . '?' . $this->getOptions()['pageName'] . '=1',
                "last_page" => $this->lastPage(),
                "last_page_url" => $this->getOptions()['path'] . '?' . $this->getOptions()['pageName'] . '=' . $this->lastPage(),
                "next_page_url" => $this->nextPageUrl(),
                "path" => $this->getOptions()['path'],
                "per_page" => $this->perPage(),
                "prev_page_url" => $this->previousPageUrl(),
                "total" => $this->total(),
            ],
        ];
    }
}

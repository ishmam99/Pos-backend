<?php

namespace App\Http\Resources;

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
            'id'=> $this->id,
            'name'=> $this->name,
            'sku'=> $this->sku,
            'slug'=> $this->slug,
            'stock'=> $this->stock,
            'price'=>$this->price,
            'image' => $this->image,
            'description' => $this->description
        ];
    }
}

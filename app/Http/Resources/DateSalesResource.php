<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DateSalesResource extends JsonResource
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
            'date' => $this->created_at,
            'done_by' => $this->user->name,
            'product_qty' => $this->saleProducts->count(),
            'total' => $this->total,
            'discount' => $this->discount,
            'sub_total' => $this->sub_total,
        ];
    }
}

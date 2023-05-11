<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExcursionTariffResource extends JsonResource
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
            //'excursion_date_id' => $this->excursion_date_id,
            'price' => $this->price,
            'price_sale' => $this->price_sale,
            'availability' => $this->availability,
            'updated_at' => $this->updated_at,
        ];
    }
}

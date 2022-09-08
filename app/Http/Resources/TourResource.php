<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\TourDate;

class TourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {   
        //dd($this->tourdate->tariff);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'days' => $this->days,
            'start_place' => $this->start_place,
            'start_time' => $this->start_time,
            'link' => $this->link,
            'dates' => TourDateResource::collection($this->tourdate),
        ];
    }
}

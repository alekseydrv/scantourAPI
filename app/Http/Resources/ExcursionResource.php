<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ExcursionDate;

class ExcursionResource extends JsonResource
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
            'days' => $this->days,
            'start_place' => $this->start_place,
            'start_time' => $this->start_time,
            'link' => $this->link,
            'dates' => ExcursionDateResource::collection($this->excursiondates),
        ];
    }
}

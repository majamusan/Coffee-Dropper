<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Locations extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "postcode" => $this->postcode,
            "updated_at" => $this->updated_at,
            "distance" => $this->distance,
            "start" => $this->start,
            "end" => [
                "lng" => (float)$this->lng,
                "lat" => (float)$this->lat,
            ],
            'opening_times' => [
                "monday" => [$this->open_Monday,$this->closed_Monday],
                "tuesday" => [$this->open_Tuesday,$this->closed_Tuesday],
                "wednesday" => [$this->open_Wednesday,$this->closed_Wednesday],
                "thursday" => [$this->open_Thursday,$this->closed_Thursday],
                "friday" => [$this->open_Friday,$this->closed_Friday],
                "saturday" => [$this->open_Saturday,$this->closed_Saturday],
                "sunday" => [$this->open_Sunday,$this->closed_Sunday],
            ],
        ];
    }
}

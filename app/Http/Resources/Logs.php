<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Logs extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "path"  => $this->path,
            "ip"    => $this->ip,
            "request"   => $this->request,
            "result"    => $this->result,
            "error"     => $this->error,
            "created_at"    => $this->created_at,
            "updated_at"    => $this->updated_at,
        ];
    }
}

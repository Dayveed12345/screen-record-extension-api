<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *

     */
    public function split($date){
        return Carbon::createFromFormat('Y-m-d H:i:s',$date);
    }
    public function toArray(Request $request): array
    {
        return [
            'name'=>$this->name,
            'size'=>$this->size,
            'length'=>$this->length,
            'path'=>$this->path,
            'uploaded_time'=>$this->uploaded_time,
            'human_time_diff'=>$this->split( $this->uploaded_time)->diffForHumans()
        ];

    }
}

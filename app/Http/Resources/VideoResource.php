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
        $split=explode(' ',$date)[0];
      return Carbon::createFromFormat('Y-m-d',$split)->format('d, F Y');
    }
    public function toArray(Request $request): array
    {
          
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'size'=>$this->size,
            'length'=>$this->length,
            'path'=>$this->path,
            'uploaded_time'=>$this->uploaded_time,
            'date_uploaded'=>$this->split($this->uploaded_time)
        ];

    }
}

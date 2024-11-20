<?php

namespace App\Http\Resources\Subject;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
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
          'id'      => $this->id ,
          'name'    => $this->name($request->header('Accept-Language','ar')),
          'image'   => is_null($this->image) ? null : $this->image,
          'type'    => $this->type ,
        ];
    }
}

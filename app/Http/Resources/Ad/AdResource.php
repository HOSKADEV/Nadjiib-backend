<?php

namespace App\Http\Resources\Ad;

use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
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
          "id"=> $this->id,
          "name"=> $this->name,
          "type" => $this->type,
          "image" => $this->image ? url($this->image) : null,
          "url" => $this->url,
          "course_id" => $this->course?->id,
          "teacher_id" => $this->teacher?->id
        ];
    }
}

<?php

namespace App\Http\Resources\Levels;

use App\Http\Resources\Section\SectionCollection;
use App\Http\Resources\Section\SectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelResource extends JsonResource
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
          'id'         => $this->id,
          'section_id' => $this->section_id,
          //'year'       => $this->year,
          'name'       => $this->name($request->header('Accept-language','ar')),
          'specialty'  => $this->specialty($request->header('Accept-language','ar')),
        ];
    }
}

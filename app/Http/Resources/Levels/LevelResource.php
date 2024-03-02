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
          'id'           => $this->id,
          'section'      => new SectionCollection($this->section()->get()),
          'year'         => $this->year,
          'name_ar'      => $this->name_ar,
          'name_fr'      => $this->name_fr,
          'name_en'      => $this->name_en,
          'specialty_ar' => $this->specialty_ar,
          'specialty_fr' => $this->specialty_fr,
          'specialty_en' => $this->specialty_en,
          'created'      => is_null($this->created_at) ? null : $this->created_at->format('d-m-Y'),
        ];
    }
}

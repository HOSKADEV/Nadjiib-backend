<?php

namespace App\Http\Resources\Section;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
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
          'id'      => $this->id,
          'name_ar' => $this->name_ar,
          'name_fr' => $this->name_fr,
          'name_en' => $this->name_en,
          'image'   => empty($this->image) ? null : url($this->image),
        ];
    }
}

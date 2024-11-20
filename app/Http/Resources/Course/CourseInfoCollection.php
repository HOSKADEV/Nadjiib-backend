<?php

namespace App\Http\Resources\Course;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseInfoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

     public $collects = CourseInfoResource::class;
    public function toArray($request)
    {
      return parent::toArray($request);
    }
}

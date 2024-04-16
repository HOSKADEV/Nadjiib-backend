<?php

namespace App\Http\Resources\Lesson;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginateLessonCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public $collects = LessonResource::class;
    public function toArray($request)
    {
      return [
          'data' => $this->collection,
          'meta' => [
            'current_page'  => $this->currentPage(),
            'last_page'     => $this->lastPage(),
            'per_page'      => $this->perPage(),
            'total'         => $this->total(),
            'count'         => $this->count(),
          ]
      ];
    }
}

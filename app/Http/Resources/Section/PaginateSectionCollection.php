<?php

namespace App\Http\Resources\Section;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginateSectionCollection extends ResourceCollection
{
    public $collects = SectionResource::class;
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

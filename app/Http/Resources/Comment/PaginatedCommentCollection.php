<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginatedCommentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public $collects = CommentResource::class;
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

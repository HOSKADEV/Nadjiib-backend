<?php

namespace App\Http\Resources\Lesson;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonFileResource extends JsonResource
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
          'id'        => $this->id,
          'lesson_id' => $this->lesson_id,
          //'file_url'  => $this->file_url,
          'file_url'  => $this->url(),
          'filename'  => $this->filename,
          'extension' => $this->extension,
          'created'   => $this->created_at->format('d-m-Y'),
        ];
    }
}

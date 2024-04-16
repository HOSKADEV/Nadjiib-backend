<?php

namespace App\Http\Resources\Lesson;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
        'course_id' => $this->course_id,
        'title'     => $this->title,
        'description' => $this->description,
        'created'     => $this->created_at->format('d-m-Y'),
        'videos'      => $this->videos()->count() === 0 ? null : new LessonVideoCollection($this->videos),
        'files'       => $this->files()->count()  === 0 ? null : new LessonFileCollection($this->files),
      ];
    }
}

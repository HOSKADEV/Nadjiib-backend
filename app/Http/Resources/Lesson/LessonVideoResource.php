<?php

namespace App\Http\Resources\Lesson;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonVideoResource extends JsonResource
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
            'video_url' => $this->video_url,
            'filename'  => $this->filename,
            'extension' => $this->extension,
            'duartion'  => $this->duartion,
            'created'   => $this->created_at->format('d-m-Y'),
        ];
    }
}

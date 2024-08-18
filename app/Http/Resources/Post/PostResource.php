<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\User\AvatarUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
          'id' => $this->id,
          'teacher_id' => $this->teacher_id,
          'avatar' => new AvatarUserResource($this->teacher->user),
          'title' => $this->title,
          'description' => $this->description,
          'video' => empty($this->video_url) ? null : url($this->video_url),
          'thumbnail' => empty($this->thumbnail) ? null : url($this->thumbnail),
          'created_at' => $this->created_at,
          'likes' => $this->likes()->count(),
          'comments' => $this->comments()->count(),
        ];
    }
}

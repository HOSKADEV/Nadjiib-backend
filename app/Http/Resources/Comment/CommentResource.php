<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\User\AvatarUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
          'student_id' => $this->student_id,
          'post_id' => $this->post_id,
          'avatar' => new AvatarUserResource($this->student->user),
          'content' => $this->content,
          'created_at' => $this->created_at,
          'likes' => $this->likes()->count(),
        ];
    }
}

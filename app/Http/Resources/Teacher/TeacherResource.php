<?php

namespace App\Http\Resources\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Section\SectionCollection;
use App\Http\Resources\Subject\SubjectCollection;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

      $controller = new Controller();

      $user = $request->user() ?? $controller->get_user_from_token($request->bearerToken());

        return [
          'teacher_id' => $this->id,
          'coupon_code' => $this->coupon->code,
          'channel_name' => $this->channel_name,
          'bio' => $this->bio,
          'cloud_chat' => $this->cloud_chat,
          'status' => boolval($this->status),
          'sections' => new SectionCollection($this->sections),
          'subjects' => new SubjectCollection($this->subjects),
          'num_posts' => $this->posts()->count(),
          'num_likes' => $this->likes()->count(),
          'is_followed' => empty($user) ? false : $user->student?->followed($this),
        ];
    }
}

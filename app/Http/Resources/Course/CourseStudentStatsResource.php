<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\Subscription\SubscriptionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseStudentStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      $user = $request->user;
      $num_videos = $this->videos()->count();
      $num_lessons = $this->lessons()->count();
      $completed_lessons = empty($user) ? 0 : $user->student?->completed($this);
      $remaining_lessons = $num_lessons - $completed_lessons;

        return [
          'id' => $this->id,
      'name' => $this->name,
      'description' => $this->description,
      'price' => $this->price,
      'image' => is_null($this->image) ? null : url($this->image),
      'teacher_name' => $this->teacher->user->name,
      'vidoes' => $num_videos,
      'lessons' => $num_lessons,
      'is_wished' => empty($user) ? false : $user->student?->wished($this),
      'is_purchased' => empty($user) ? false : $user->student?->purchased($this),
      'is_owned' => empty($user) ? false : $user->student?->owns($this),
      'completed_lessons' => $completed_lessons,
      'remaining_lessons' => $remaining_lessons,
      'subscription' => empty($user) ? null : new SubscriptionResource($user->student?->purchases()->where('course_id',$this->id)->first()?->subscription)
        ];
    }
}

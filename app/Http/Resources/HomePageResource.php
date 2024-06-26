<?php

namespace App\Http\Resources;

use App\Models\Ad;
use App\Models\Course;
use App\Http\Resources\Ad\AdCollection;
use App\Http\Resources\Levels\LevelResource;
use App\Http\Resources\Course\CourseCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Subject\SubjectCollection;
use App\Http\Resources\Course\CourseInfoCollection;

class HomePageResource extends JsonResource
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

    return [
      'name' => empty($user) ? null : $user->name,
      'image' => empty($user) ? null : (empty($user->image) ? null : url($user->image)),
      'level' => empty($user) ? null : new LevelResource($user->student->level),
      'subjects' => empty($user) ? null : new SubjectCollection($user->student->level->subjects),
      'notifications' => empty($user) ? 0 : $user->notifications()->count(),
      'wishlist' => empty($user) ? 0 : $user->student?->wishlists()->count(),
      'ads' => new AdCollection(Ad::inRandomOrder()->limit(5)->get()),
      'best_sellers' => new CourseInfoCollection(Course::inRandomOrder()->limit(5)->get()),
      'suggestions' => new CourseInfoCollection(Course::inRandomOrder()->limit(5)->get()),
      'recommended' => new CourseInfoCollection(Course::inRandomOrder()->limit(5)->get()),
    ];
  }
}

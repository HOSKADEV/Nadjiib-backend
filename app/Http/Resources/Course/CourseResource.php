<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\Levels\LevelResource;
use App\Http\Resources\Levels\LevelCollection;
use App\Http\Resources\Section\SectionResource;
use App\Http\Resources\Subject\SubjectResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Subject\SubjectCollection;
use App\Http\Resources\CourseLevel\CourseLevelResource;
use App\Http\Resources\LevelCourse\LevelCourseResource;
use App\Http\Resources\CourseLevel\CourseLevelCollection;
use App\Http\Resources\CourseSection\CourseSectionResource;
use App\Http\Resources\CourseSection\CourseSectionCollection;

class CourseResource extends JsonResource
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
          'id'          => $this->id,
          'teacher_id'  => $this->teacher_id,
          'teacher_name' => $this->teacher->user->name,
          'subject'     => new SubjectResource($this->subject),
          'name'        => $this->name,
          'description' => $this->description,
          'price'       => $this->price,
          'image'       => is_null($this->image) ? null : url($this->image),
          'video'       => is_null($this->video) ? null : url($this->video),
          'status'      => $this->status,
          'level'       => $this->courseLevel()-> count() === 0 ? null : new CourseLevelCollection($this->courseLevel),
          'section'     => $this->courseSection()-> count() === 0  ? null : new CourseSectionCollection($this->courseSection),
          'vidoes'      => $this->videos()->count(),
          'lessons'     => $this->lessons()->count(),
          'is_wished'   => empty($user) ? false : in_array($this->id, $user->student?->wishlists()->pluck('course_id')->toArray()),
        ];
    }
}

<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\Levels\LevelResource;
use App\Http\Resources\Levels\LevelCollection;
use App\Http\Resources\Section\SectionResource;
use App\Http\Resources\Subject\SubjectResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Section\SectionCollection;
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
          'teacher_image' => is_null($this->teacher->user->image) ? null : url($this->teacher->user->image),
          'subject'     => new SubjectResource($this->subject),
          'name'        => $this->name,
          'description' => $this->description,
          'price'       => $this->price,
          'image'       => is_null($this->image) ? null : url($this->image),
          'video'       => is_null($this->video) ? null : url($this->video),
          'thumbnail'   => is_null($this->thumbnail) ? null : url($this->thumbnail),
          'status'      => $this->status,
          //'level'       => $this->courseLevel()-> count() === 0 ? null : new CourseLevelCollection($this->courseLevel),
          //'section'     => $this->courseSection()-> count() === 0  ? null : new CourseSectionCollection($this->courseSection),
          'levels'       => new LevelCollection($this->levels),
          'sections'     => new SectionCollection($this->sections),
          'lessons'     => $this->lessons()->count(),
          'videos'      => $this->videos()->count(),
          'files'     => $this->files()->count(),
          'is_wished'   => empty($user) ? false : $user->student?->wished($this),
          'is_purchased'   => empty($user) ? false : $user->student?->purchased($this),
          'is_owned'   => empty($user) ? false : $user->student?->owns($this),
        ];
    }
}

<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\CourseLevel\CourseLevelCollection;
use App\Http\Resources\CourseLevel\CourseLevelResource;
use App\Http\Resources\CourseSection\CourseSectionCollection;
use App\Http\Resources\CourseSection\CourseSectionResource;
use App\Http\Resources\LevelCourse\LevelCourseResource;
use App\Http\Resources\Levels\LevelCollection;
use App\Http\Resources\Levels\LevelResource;
use App\Http\Resources\Section\SectionResource;
use App\Http\Resources\Subject\SubjectCollection;
use App\Http\Resources\Subject\SubjectResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
          'id'          => $this->id,
          'teacher_id'  => $this->teacher_id,
          'subject'     => new SubjectResource($this->subject),
          'name'        => $this->name,
          'description' => $this->description,
          'price'       => $this->price,
          'image'       => is_null($this->image) ? null : url($this->image),
          'video'       => $this->video,
          'status'      => $this->status,
          'level'       => $this->courseLevel()-> count() === 0 ? null : new CourseLevelCollection($this->courseLevel),
          'section'     => $this->courseSection()-> count() === 0  ? null : new CourseSectionCollection($this->courseSection),
        ];
    }
}

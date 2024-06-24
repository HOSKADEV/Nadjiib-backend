<?php

namespace App\Repositories\Course;


use App\Models\Course;

use App\Repositories\Course\CourseRepository;
use App\Http\Filters\Course\CourseKeywordSearch;
use App\Http\Filters\Course\FiltersCourseSubject;
use App\Http\Filters\Course\FiltersCourseTeacher;

class EloquentCourse implements CourseRepository
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Course::all();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Course::with('lessons')->find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $course = Course::create($data);

        return $course;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $course = $this->find($id);

        $course->update($data);

        return $course;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $course = $this->find($id);

        return $course->delete();
    }

    /**
     * @param $perPage
     * @param null $search
     * @param null $subject
     * @param null $teacher
     * @param null $status
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function paginate($perPage, $search = null, $subject = null, $teacher = null,$status = 'ACCEPTED')
    {
        $query = Course::query();

        if ($status) {
            $query->where('status', $status);
        }
        if ($search) {
            (new CourseKeywordSearch)($query, $search);
        }
        if ($subject) {
            (new FiltersCourseSubject)($query, $subject);
        }
        if ($teacher) {
            (new FiltersCourseTeacher)($query, $teacher);
        }

        $result = $query->orderBy('id', 'desc')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }
        return $result;
    }
}

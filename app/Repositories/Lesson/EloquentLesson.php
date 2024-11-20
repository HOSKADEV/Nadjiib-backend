<?php

namespace App\Repositories\Lesson;

use App\Models\Lesson;
use App\Http\Filters\LessonKeywordSearch;
use App\Repositories\Lesson\LessonRepository;

class EloquentLesson implements LessonRepository
{
    /**
     * {@inheritdoc}
     */
    public function all(){
        return Lesson::all();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Lesson::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $lesson = Lesson::create($data);

        return $lesson;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $lesson = $this->find($id);

        $lesson->update($data);

        return $lesson;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $lesson = $this->find($id);

        return $lesson->delete();
    }

    /**
     * @param $perPage
     * @param null $status
     * @param null $searchFrom
     * @param $searchTo
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function paginate($perPage, $courseId, $search = null)
    {
        $query = Lesson::query();
        if ($search) {
            (new LessonKeywordSearch)($query, $search);
        }
        $result = $query->whereCourseId($courseId)->orderBy('id', 'asc')
                  ->paginate($perPage);
        if ($search) {
            $result->appends(['search' => $search]);
        }
        return $result;
    }

    public function get($courseId, $search = null)
    {
        $query = Lesson::query();
        if ($search) {
            (new LessonKeywordSearch)($query, $search);
        }
        $result = $query->whereCourseId($courseId)->orderBy('id', 'asc')->get();
        if ($search) {
            $result->appends(['search' => $search]);
        }
        return $result;
    }
}

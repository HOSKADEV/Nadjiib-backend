<?php

namespace App\Repositories\LessonVideo;

use App\Models\LessonVideo;
use App\Http\Filters\LessonKeywordSearch;
use App\Repositories\LessonVideo\LessonVideoRepository;

class EloquentLessonVideo implements LessonVideoRepository
{
    /**
     * {@inheritdoc}
     */
    public function all(){
        return LessonVideo::all();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return LessonVideo::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $lessonVideo = LessonVideo::create($data);

        return $lessonVideo;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $lessonVideo = $this->find($id);

        $lessonVideo->update($data);

        return $lessonVideo;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $lessonVideo = $this->find($id);

        return $lessonVideo->delete();
    }

    /**
     * @param $perPage
     * @param null $status
     * @param null $searchFrom
     * @param $searchTo
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function paginate($perPage, $search = null)
    {
        $query = LessonVideo::query();

        if ($search) {
            (new LessonKeywordSearch)($query, $search);
        }

        $result = $query->orderBy('id', 'desc')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }
        return $result;
    }
}

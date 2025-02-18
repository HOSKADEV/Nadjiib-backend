<?php

namespace App\Repositories\CourseLevel;

use App\Models\CourseLevel;
use App\Http\Filters\LevelKeywordSearch;
use App\Repositories\CourseLevel\CourseLevelRepository;


class EloquentCourseLevel implements CourseLevelRepository
{
    /**
     * {@inheritdoc}
     */
    public function all(){
        return CourseLevel::all();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return CourseLevel::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $CourseLevel = CourseLevel::create($data);

        return $CourseLevel;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $CourseLevel = $this->find($id);

        $CourseLevel->update($data);

        return $CourseLevel;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $CourseLevel = $this->find($id);

        return $CourseLevel->delete();
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
        $query = CourseLevel::query();

        if ($search) {
            (new LevelKeywordSearch)($query, $search);
        }

        $result = $query->orderBy('id', 'desc')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }
        return $result;
    }
}

<?php

namespace App\Repositories\CourseSection;

use App\Models\CourseSection;
use App\Http\Filters\LevelKeywordSearch;
use App\Repositories\CourseSection\CourseSectionRepository;


class EloquentCourseSection implements CourseSectionRepository
{
    /**
     * {@inheritdoc}
     */
    public function all(){
        return CourseSection::all();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return CourseSection::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $CourseLevel = CourseSection::create($data);

        return $CourseLevel;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $CourseSection = $this->find($id);

        $CourseSection->update($data);

        return $CourseSection;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $CourseSection = $this->find($id);

        return $CourseSection->delete();
    }
    /**
     * {@inheritdoc}
     */
    public function findCourseSection($course_id)
    {
        return CourseSection::whereCourseId($course_id);
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
        $query = CourseSection::query();

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

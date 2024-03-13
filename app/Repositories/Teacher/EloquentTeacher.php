<?php

namespace App\Repositories\Teacher;

use App\Models\Teacher;
use App\Http\Filters\User\UserKeywordSearch;
use App\Repositories\Teacher\TeacherRepository;

class EloquentTeacher implements TeacherRepository
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Teacher::with('user')->get();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Teacher::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $teacher = Teacher::create($data);

        return $teacher;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $teacher = $this->find($id);

        $teacher->update($data);

        return $teacher;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $teacher = $this->find($id);

        return $teacher->delete();
    }

    /**
     * @param $perPage
     * @param null $status
     * @param null $searchFrom
     * @param $searchTo
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function paginate($perPage, $search = null, $status = null)
    {
        $query = Teacher::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            (new UserKeywordSearch)($query, $search);
        }

        $result = $query->orderBy('id', 'desc')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }
        return $result;
    }
}

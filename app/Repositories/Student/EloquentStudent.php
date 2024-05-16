<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Repositories\Student\StudentRepository;
use App\Http\Filters\Student\StudentKeywordSearch;

class EloquentStudent implements StudentRepository
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Student::all();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Student::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $student = Student::create($data);

        return $student;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $student = $this->find($id);

        $student->update($data);

        return $student;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $student = $this->find($id);

        return $student->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function findByEmail($email){
      return Student::whereEmail($email)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function studentExists($id)
    {
        return Student::whereUserId($id)->exists();
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
        $query = Student::query();

        if ($status) {
            $query->where('status', $status);
        }



        $result = $query->orderBy('id', 'desc')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }
        return $result;
    }
}

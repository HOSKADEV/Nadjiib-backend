<?php

namespace App\Repositories\Subject;

use App\Models\Level;
use App\Models\Subject;
use App\Http\Filters\SubjectKeywordSearch;
use App\Repositories\Subject\SubjectRepository;

class EloquentSubject implements SubjectRepository
{
    /**
     * {@inheritdoc}
     */
    public function all(){
        return Subject::all();
    }

    /**
     * {@inheritdoc}
     */
    public function table(){
        return Subject::withoutTrashed();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Subject::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $subject = Subject::create($data);

        return $subject;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $subject = $this->find($id);

        $subject->update($data);

        return $subject;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $subject = $this->find($id);

        return $subject->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function getByLevel($level_id)
    {
      $level = Level::findOrFail($level_id);
      return $level->subjects()->whereType('academic');
    }

    /**
     * @param $perPage
     * @param null $status
     * @param null $searchFrom
     * @param $searchTo
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function paginate($perPage, $search = null, $type = null)
    {
        $query = Subject::query();
        if ($search) {
            (new SubjectKeywordSearch)($query, $search);
        }

        if ($type) {
          $query = $query->where('type', $type);
      }

        $result = $query->orderBy('id', 'desc')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }
        return $result;
    }
}

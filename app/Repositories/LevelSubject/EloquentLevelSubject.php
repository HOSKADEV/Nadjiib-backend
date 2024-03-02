<?php

namespace App\Repositories\LevelSubject;

use App\Models\LevelSubject;
use App\Http\Filters\SubjectKeywordSearch;
use App\Repositories\LevelSubject\LevelSubjectRepository;

class EloquentLevelSubject implements LevelSubjectRepository
{
    /**
     * {@inheritdoc}
     */
    public function all(){
        return LevelSubject::with('subject','level')->get();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return LevelSubject::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $levelSubject = LevelSubject::create($data);

        return $levelSubject;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $levelSubject = $this->find($id);

        $levelSubject->update($data);

        return $levelSubject;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $levelSubject = $this->find($id);

        return $levelSubject->delete();
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
        $query = LevelSubject::query()->with('subject','level');
        // if ($search) {
        //     (new SubjectKeywordSearch)($query, $search);
        // }

        $result = $query->orderBy('id', 'desc')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }
        return $result;
    }
}

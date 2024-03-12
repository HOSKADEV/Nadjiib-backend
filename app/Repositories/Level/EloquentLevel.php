<?php

namespace App\Repositories\Level;

use App\Models\Level;
use App\Http\Filters\LevelKeywordSearch;
use App\Repositories\Level\LevelRepository;

class EloquentLevel implements LevelRepository
{
    /**
     * {@inheritdoc}
     */
    public function all(){
        return Level::all();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Level::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $level = Level::create($data);

        return $level;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $level = $this->find($id);

        $level->update($data);

        return $level;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $level = $this->find($id);

        return $level->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function getBySection($section_id)
    {
      return Level::whereSectionId($section_id)->get();
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
        $query = Level::query();

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

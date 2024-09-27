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


    /**
     * @param $perPage
     * @param null $status
     * @param null $searchFrom
     * @param $searchTo
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function years($perPage, $search = null, $section_id = null)
    {
      $query = Level::query();

      if($section_id){
        $query = $query->where('section_id', $section_id);
      }

        $query = $query->groupBy('year','section_id','name_ar','name_fr','name_en')
                      ->select('year','section_id','name_ar','name_fr','name_en');

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

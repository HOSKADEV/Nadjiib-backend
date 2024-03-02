<?php

namespace App\Repositories\Section;

use App\Models\Section;
use App\Http\Filters\SectionKeywordSearch;
use App\Repositories\Section\SectionRepository;

class EloquentSection implements SectionRepository
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Section::all();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Section::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $section = Section::create($data);

        return $section;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $section = $this->find($id);

        $section->update($data);

        return $section;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $section = $this->find($id);

        return $section->delete();
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
        $query = Section::query();

        if ($search) {
            (new SectionKeywordSearch)($query, $search);
        }

        $result = $query->orderBy('id', 'desc')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }
        return $result;
    }
}

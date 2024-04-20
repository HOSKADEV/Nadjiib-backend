<?php

namespace App\Repositories\Purchase;

use App\Models\Purchase;
use App\Http\Filters\SectionKeywordSearch;
use App\Repositories\Purchase\PurchaseRepository;

class EloquentPurchase implements PurchaseRepository
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Purchase::all();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Purchase::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $purchase = Purchase::create($data);

        return $purchase;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $purchase = $this->find($id);

        $purchase->update($data);

        return $purchase;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $purchase = $this->find($id);

        return $purchase->delete();
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
        $query = Purchase::query();
        
        if ($status) {
            $query->where('status', $status);
        }
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

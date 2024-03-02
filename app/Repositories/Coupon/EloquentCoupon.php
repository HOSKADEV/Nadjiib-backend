<?php

namespace App\Repositories\Coupon;

use App\Models\Coupon;
use App\Http\Filters\LevelKeywordSearch;
use App\Repositories\Coupon\CouponRepository;

class EloquentCoupon implements CouponRepository
{
    /**
     * {@inheritdoc}
     */
    public function all(){
        return Coupon::all();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Coupon::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $coupon = Coupon::create($data);

        return $coupon;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $coupon = $this->find($id);

        $coupon->update($data);

        return $coupon;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $coupon = $this->find($id);

        return $coupon->delete();
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
        $query = Coupon::query();

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
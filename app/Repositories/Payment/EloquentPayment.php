<?php

namespace App\Repositories\Payment;


use App\Models\Payment;
use App\Http\Filters\SectionKeywordSearch;
use App\Repositories\Payment\PaymentRepository;

class EloquentPayment implements PaymentRepository
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Payment::all();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Payment::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $payment = Payment::create($data);

        return $payment;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $payment = $this->find($id);

        $payment->update($data);

        return $payment;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $payment = $this->find($id);

        return $payment->delete();
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
        $query = Payment::query();

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

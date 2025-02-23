<?php

namespace App\Repositories\Wallet;

use App\Enums\WalletAction;
use App\Enums\WalletTransactionStatus;
use App\Models\WalletTransaction;
use App\Http\Filters\User\UserKeywordSearch;

class EloquentWallet implements WalletRepository
{
    /**
     * Return all deposit transactions.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return WalletTransaction::with(['user'])
            ->where('type', WalletAction::DEPOSIT)
            ->orderBy('status', 'asc')
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * Find a wallet transaction by its id.
     *
     * @param  mixed $id
     * @return WalletTransaction|null
     */
    public function find($id)
    {
        return WalletTransaction::find($id);
    }

    /**
     * Create a new wallet transaction.
     *
     * @param  array $data
     * @return WalletTransaction
     */
    public function create(array $data)
    {
        return WalletTransaction::create($data);
    }

    /**
     * Update an existing wallet transaction.
     *
     * @param  mixed $id
     * @param  array $data
     * @return WalletTransaction
     */
    public function update($id, array $data)
    {
        $wallet = $this->find($id);
        $wallet->update($data);
        return $wallet;
    }

    /**
     * Delete an existing wallet transaction.
     *
     * @param  mixed $id
     * @return bool
     */
    public function delete($id)
    {
        $wallet = $this->find($id);
        return $wallet->delete();
    }

    /**
     * Paginate deposit transactions with optional filters.
     *
     * @param  int         $perPage
     * @param  string|null $search
     * @param  string|null $status
     * @param  string|null $role
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, $search = null, $status = null, $role = null)
    {
        $query = WalletTransaction::query()
            ->where('type', WalletAction::DEPOSIT)
            ->orderBy('status', 'asc')
            ->orderBy('id', 'desc')
            ->with(['user']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($role) {
            $query->where('role', $role);
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

    /**
     * Change the status of a wallet transaction.
     *
     * @param  mixed $id
     * @return WalletTransaction
     */
    public function changeStatus($id)
    {
        $wallet = $this->find($id);
        $wallet->changeStatus(); // Assumes the model has a changeStatus method.
        return $wallet;
    }

    /**
     * Get deposit transactions for a specific user.
     *
     * @param  int         $user_id
     * @param  int         $perPage
     * @param  string|null $search
     * @param  string|null $status
     * @param  string|null $type
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getDepositTransactions(int $user_id, int $perPage, string $search = null, string $status = null, string $type = null)
    {
        $query = WalletTransaction::query()->where('user_id', $user_id);

        if ($status) {
            $query->where('status', $status);
        }

        if ($type) {
            $query->where('type', $type);
        }

        $result = $query->orderBy('id', 'desc')
            ->paginate($perPage);

        return $result;
    }
}

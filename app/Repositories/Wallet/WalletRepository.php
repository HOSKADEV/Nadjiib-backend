<?php

namespace App\Repositories\Wallet;

interface WalletRepository
{
    /**
     * Get all deposit transactions.
     *
     * @return mixed
     */
    public function all();

    /**
     * Find a wallet transaction.
     *
     * @param mixed $id
     * @return mixed
     */
    public function find($id);

    /**
     * Create a new wallet transaction.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update an existing wallet transaction.
     *
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Delete a wallet transaction.
     *
     * @param mixed $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Paginate deposit transactions.
     *
     * @param int         $perPage
     * @param string|null $search
     * @param string|null $status
     * @param string|null $role
     * @return mixed
     */
    public function paginate($perPage, $search = null, $status = null, $role = null);

    /**
     * Change the status of a wallet transaction.
     *
     * @param mixed $id
     * @return mixed
     */
    public function changeStatus($id);

    /**
     * Get deposit transactions for a specific user.
     *
     * @param int         $user_id
     * @param int         $perPage
     * @param string|null $search
     * @param string|null $status
     * @param string|null $type
     * @return mixed
     */
    public function getDepositTransactions(int $user_id, int $perPage, string $search = null, string $status = null, string $type = null);
}

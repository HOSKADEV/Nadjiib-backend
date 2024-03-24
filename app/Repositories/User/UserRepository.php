<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepository
{
    /**
     * Get all available User.
     * @return mixed
     */
    public function all();

    /**
     * {@inheritdoc}
     */
    public function find($id);
    /**
     * {@inheritdoc}
     */
    public function create(array $data);

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data);

    /**
     * {@inheritdoc}
     */
    public function delete($id);

    /**
     * {@inheritdoc}
     */
    public function findByEmail($email);

    /**
     * Paginate Users.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null, $status = null);

    /**
     * Change Status Account.
     *
     * @param $id
     * @return mixed
     */
    public function changeStatus($id);
}

<?php

namespace App\Repositories\Wishlist;

interface WishlistRepository
{
    /**
     * Get all available Level.
     * @return mixed
     */
    public function all();

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
    public function getByStudent($student_id);
    /**
     * {@inheritdoc}
     */
    public function findStudent($student_id);

    /**
     * Paginate Levels.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $courseId);

}

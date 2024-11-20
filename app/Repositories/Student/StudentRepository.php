<?php

namespace App\Repositories\Student;

use App\Models\Student;

interface StudentRepository
{
    /**
     * Get all available Student.
     * @return mixed
     */
    public function all();
    /**
     * Get all available Student.
     * @return mixed
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
     * {@inheritdoc}
     */

    public function studentExists($id);

    /**
     * Paginate Students.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null, $status = null);
}

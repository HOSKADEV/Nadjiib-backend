<?php

namespace App\Repositories\Teacher;

use App\Models\Teacher;

interface TeacherRepository
{
    /**
     * Get all available Teacher.
     * @return mixed
     */
    public function all();

    /**
     * {@inheritdoc}
     */
    public function create(array $data, array $sections = [], array $subjects = []);

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
    public function teacherExists($id);

    /**
     * Paginate Teachers.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null, $status = null);
}

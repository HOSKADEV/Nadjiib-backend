<?php
namespace App\Repositories\Subject;

interface SubjectRepository
{
    /**
     * Get all available Subject.
     * @return mixed
     */
    public function all();

     /**
     * {@inheritdoc}
     */
    public function table();
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
    public function getByLevel($level_id);

    /**
     * Paginate Subjects.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null, $type = null);
}

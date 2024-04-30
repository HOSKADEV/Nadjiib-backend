<?php

namespace App\Repositories\Review;

interface ReviewRepository
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
    public function getByCourse($course_id);

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

<?php

namespace App\Repositories\Lesson;

interface LessonRepository
{
    /**
     * Get all available Level.
     * @return mixed
     */
    public function all();
    /**
     * Get all available Level.
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
     * Paginate Levels.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $courseId, $search = null);

       /**
     * Paginate Levels.
     *
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function get($courseId, $search = null);

}

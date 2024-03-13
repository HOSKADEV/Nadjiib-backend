<?php

namespace App\Repositories\Course;

interface CourseRepository
{
    /**
     * Get all available Course.
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
     * Paginate Courses.
     *
     * @param $perPage
     * @param null $search
     * @param null $subject
     * @param null $teacher
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null, $subject = null, $teacher = null,$status = null);

}

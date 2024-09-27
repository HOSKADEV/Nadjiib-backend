<?php

namespace App\Repositories\Level;

interface LevelRepository
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
    public function getBySection($section_id);

    /**
     * Paginate Levels.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null);


    /**
     * Paginate Years.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function years($perPage, $search = null, $section_id = null);

}

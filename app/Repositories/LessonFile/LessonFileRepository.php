<?php

namespace App\Repositories\LessonFile;

interface LessonFileRepository
{
    /**
     * Get all available Level.
     * @return mixed
     */
    public function all();

    /**
     * {@inheritdoc}
     */
    public function create(array $data, array $files = [], array $filenames = [], array $extensions = []);

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data);

    /**
     * {@inheritdoc}
     */
    public function delete($id);


}

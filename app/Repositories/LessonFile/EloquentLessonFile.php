<?php

namespace App\Repositories\LessonFile;

use App\Http\Filters\LessonKeywordSearch;
use App\Models\LessonFile;
use App\Repositories\LessonFile\LessonFileRepository;

class EloquentLessonFile implements LessonFileRepository
{
    /**
     * {@inheritdoc}
     */
    public function all(){
        return LessonFile::all();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return LessonFile::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data, array $files = [], array $filenames = [], array $extensions = [])
    {
      // dd($lessonFile,count($files),$data, $files,$filenames,$extensions);
        $lenght = count($files);
        for ($i = 0; $i < $lenght ; $i++) {
            $lessonFile = new LessonFile();
            $lessonFile->lesson_id = $data['lesson_id'];
            $lessonFile->file_url  = $files[$i];;
            $lessonFile->filename  = $filenames[$i];
            $lessonFile->extension = $extensions[$i];
            $lessonFile->save();

        }

        return $lessonFile;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $lessonFile = $this->find($id);

        $lessonFile->update($data);

        return $lessonFile;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $lessonFile = $this->find($id);

        return $lessonFile->delete();
    }

}

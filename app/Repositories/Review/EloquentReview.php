<?php

namespace App\Repositories\Review;

use App\Models\Review;
use App\Repositories\Review\ReviewRepository;

class EloquentReview implements ReviewRepository
{
    /**
     * {@inheritdoc}
     */
    public function all(){
        return Review::all();
    }
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Review::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $review = Review::create($data);

        return $review;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $review = $this->find($id);

        $review->update($data);

        return $review;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $review = $this->find($id);

        return $review->delete();
    }
    /**
     * {@inheritdoc}
     */
    public function getByCourse($course_id)
    {
        $review = Review::whereCourseId($course_id)->get();

        return $review;
    }

    /**
     * @param $perPage
     * @param null $status
     * @param null $searchFrom
     * @param $searchTo
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
     */
    public function paginate($perPage, $courseId)
    {

        $review = Review::whereCourseId($courseId)->orderBy('id', 'desc')
                    ->paginate($perPage);

        return $review;
    }
}

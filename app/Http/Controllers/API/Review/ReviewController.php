<?php

namespace App\Http\Controllers\API\Review;

use App\Http\Controllers\Controller;
use App\Http\Resources\Review\ReviewCollection;
use App\Http\Resources\Review\ReviewResource;
use App\Repositories\Review\ReviewRepository;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    private $review;

    public function __construct(ReviewRepository $review)
    {
        $this->review = $review;
    }

    public function get()
    {
        try
        {

        }
        catch(Exception $e){
          return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
          ]);
      }
    }

    public function create(Request $request)
    {
        $validtion = Validator::make($request->all(),[
          'course_id'  => 'required|exists:courses,id',
          'student_id' => 'required|exists:students,id',
          'rating'     => 'sometimes|between:1,5',
          'comment'    => 'sometimes',
        ]);
        if ($validtion->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validtion->errors()
            ], 403);
        }
        try
        {
            $review = $this->review->create($request->all());

            if (!$review) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Something went wrong'
                ]);
            }
            else {
                return response()->json([
                    'status'  => true,
                    'message' => 'Review created successfully',
                    'data'    => new ReviewResource($review)
                ]);
            }
        }
        catch(Exception $e){
            return response()->json([
              'status'  => false,
              'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        $validtion = Validator::make($request->all(),[
          'review_id'  => 'required|exists:reviews,id',
          'course_id'  => 'sometimes|exists:courses,id',
          'student_id' => 'sometimes|exists:students,id',
          'rating'     => 'sometimes|between:1,5',
          'comment'    => 'sometimes',
        ]);
        if ($validtion->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validtion->errors()
            ], 403);
        }
        try
        {
            $review = $this->review->update($request->review_id, $request->all());

            if (!$review) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Review not found'
                ]);
            }
            else {
                return response()->json([
                    'status'  => true,
                    'message' => 'Review updated successfully',
                    'data'    => new ReviewResource($review)
                ]);
            }

        }
        catch(Exception $e){
            return response()->json([
              'status'  => false,
              'message' => $e->getMessage()
            ]);
        }
    }

    public function delete(Request $request)
    {
        $validtion = Validator::make($request->all(),[
          'review_id'  => 'required|exists:reviews,id',
        ]);
        if ($validtion->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validtion->errors()
            ], 403);
        }
        try
        {
            $review = $this->review->delete($request->review_id);

            if (!$review) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Review not deleted',
                ]);
            }
            else {
                return response()->json([
                    'status'  => true,
                    'message' => 'Review deleted successfully',
                ]);
            }

        }
        catch(Exception $e){
            return response()->json([
              'status'  => false,
              'message' => $e->getMessage()
            ]);
        }
    }


}

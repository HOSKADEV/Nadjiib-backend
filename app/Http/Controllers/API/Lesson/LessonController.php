<?php

namespace App\Http\Controllers\API\Lesson;

use App\Http\Controllers\Controller;
use App\Http\Resources\Lesson\LessonCollection;
use App\Http\Resources\Lesson\LessonFileResource;
use App\Http\Resources\Lesson\LessonResource;
use App\Http\Resources\Lesson\LessonVideoResource;
use App\Http\Resources\Lesson\PaginateLessonCollection;
use App\Repositories\Lesson\LessonRepository;
use App\Repositories\LessonFile\LessonFileRepository;
use App\Repositories\LessonVideo\LessonVideoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    private $lesson;
    private $lessonVideo;
    private $lessonFile;
    public function __construct(
      LessonRepository       $lesson,
      LessonVideoRepository  $lessonVideo,
      LessonFileRepository   $lessonFile)
    {
        $this->lesson      = $lesson;
        $this->lessonVideo = $lessonVideo;
        $this->lessonFile  = $lessonFile;
    }
    public function get(Request $request)
    {
        $validtion = Validator::make($request->all(), [
            'search_byTitle' => 'sometimes|string',
            'course_id'      => 'required|exists:courses,id'
        ]);

        if ($validtion->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validtion->errors()
            ], 403);
        }

        try {
            $lessons = $this->lesson->paginate(10,$request->course_id,$request->search_byTitle);

            return response()->json([
              'status' => true,
              'data'   => new PaginateLessonCollection($lessons)
            ]);
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
        $validation = Validator::make($request->all(), [
          'course_id'     => 'required|exists:courses,id',
          'title'         => 'required',
          'description'   => 'required',
          'video_url'     => 'required',
          'video_filename'  => 'sometimes',
          'video_extension' => 'sometimes',
          'video_duartion'  => 'sometimes',
          'file_url'        => 'required',
          'file_filename'   => 'sometimes',
          'file_extension'  => 'sometimes',
          'file_duartion'   => 'sometimes',
        ]);

        if ($validation->fails()) {
          return response()->json([
            'status' => false,
            'message' => 'Invalid data sent',
            'errors' => $validation->errors()
          ], 422);
        }

        try
        {
          DB::beginTransaction();
            // ** create a new data for lesson if necessary
            $lesson = $this->lesson->create($request->only(['course_id','title','description']));

            if ($lesson) {
                //  ** create a new data for lesson video
                $dataVideo = array_replace($request->only([
                  'video_url',
                ]),[
                    'lesson_id' => $lesson->id,
                    'filename'  => $request->video_filename,
                    'extension' => $request->video_extension,
                    'duration'  => $request->video_duartion
                ]);
                //  ** create a new data for lesson File
                $dataFile = array_replace($request->only([]),[
                  'lesson_id' => $lesson->id,
                ]);



                $lessonVideo = $this->lessonVideo->create($dataVideo);
                $lessonFile  = $this->lessonFile->create($dataFile,
                                      $request->file_url,
                                      $request->file_filename,
                                      $request->file_extension);

          DB::commit();
                return response()->json([
                  'status'   => true,
                  'message'  => 'Lesson Create Successfully',
                  'data'     => new LessonResource($lesson)
                ]);
            }
            else {
              DB::rollBack();
                return response()->json([
                  'status'   => false,
                  'message'  => 'Lesson Create Failed',
                ]);
            }
        }
        catch(Exception $e){
          DB::rollBack();
          return response()->json([
            'status'  => false,
            'message' => $e->getMessage()
          ]);
      }
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'lesson_id'   => 'required|exists:lessons,id',
            'title'       => 'required',
            'description' => 'required',
        ]);

        if ($validation->fails()) {
          return response()->json([
            'status'  => false,
            'message' => 'Invalid data sent',
            'errors'  => $validation->errors()
          ], 422);
        }

        try
        {
            $lesson = $this->lesson->find($request->lesson_id);
            if (is_null($lesson)) {
              return response()->json([
                "status"  => false,
                "message" => "Course not found."
              ],404);
            }
            $lesson = $this->lesson->update($request->lesson_id, $request->except(['lesson_id']));
            if(!$lesson){
              return response()->json([
                'status'  => false,
                'message' => 'Lesson Update Failed',
              ]);
            }
            else {
              return response()->json([
                'status'  => true,
                'message' => 'Lesson Update Successfully',
                'data'    => new LessonResource($lesson)
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
        $validation = Validator::make($request->all(), [
            'lesson_id'   => 'required|exists:lessons,id',
        ]);

        if ($validation->fails()) {
          return response()->json([
            'status'  => false,
            'message' => 'Invalid data sent',
            'errors'  => $validation->errors()
          ], 422);
        }

        try {
            $lesson = $this->lesson->delete($request->lesson_id);

            if (!$lesson) {
                return response()->json([
                  'status'  => false,
                  'message' => 'Lesson Not Found',
                ]);
            } else {
                return response()->json([
                  'status'  => true,
                  'message' => 'Lesson Deleted Successfully',
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

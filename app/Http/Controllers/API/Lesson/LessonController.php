<?php

namespace App\Http\Controllers\API\Lesson;

use Exception;
use App\Models\LessonFile;
use Illuminate\Http\Request;
use App\Http\Traits\uploadFile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Lesson\LessonResource;
use App\Repositories\Lesson\LessonRepository;
use App\Http\Resources\Lesson\LessonCollection;
use App\Http\Resources\Lesson\LessonFileResource;
use App\Http\Resources\Lesson\LessonVideoResource;
use App\Repositories\LessonFile\LessonFileRepository;
use App\Http\Resources\Lesson\PaginateLessonCollection;
use App\Repositories\LessonVideo\LessonVideoRepository;

class LessonController extends Controller
{

  use uploadFile;
  private $lesson;
  private $lessonVideo;
  private $lessonFile;
  public function __construct(
    LessonRepository $lesson,
    LessonVideoRepository $lessonVideo,
    LessonFileRepository $lessonFile
  ) {
    $this->lesson = $lesson;
    $this->lessonVideo = $lessonVideo;
    $this->lessonFile = $lessonFile;
  }
  public function get(Request $request)
  {
    $validtion = Validator::make($request->all(), [
      'search_byTitle' => 'sometimes|string',
      'course_id' => 'required|exists:courses,id'
    ]);

    if ($validtion->fails()) {
      return response()->json([
        "status" => false,
        "errors" => $validtion->errors()
      ], 403);
    }

    try {
      //$lessons = $this->lesson->paginate(10, $request->course_id, $request->search_byTitle);
      $lessons = $this->lesson->get($request->course_id, $request->search_byTitle);
      return response()->json([
        'status' => true,
        'data' => new LessonCollection($lessons)
      ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function create(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'course_id' => 'required|exists:courses,id',
      'title' => 'required',
      'description' => 'required',
      'video_url' => 'required',
      'video_filename' => 'sometimes',
      'video_extension' => 'sometimes',
      'video_duartion' => 'sometimes',
      'file_url' => 'sometimes',
      'file_filename' => 'sometimes',
      'file_extension' => 'sometimes',
      'file_duartion' => 'sometimes',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {
      DB::beginTransaction();
      // ** create a new data for lesson if necessary
      $lesson = $this->lesson->create($request->only(['course_id', 'title', 'description']));

      if ($lesson) {

        if ($request->has('video_url')) {

          $video_url = gettype($request->video_url) == 'string'
            ? $request->video_url
            : $this->SaveVideo($request->video_url, 'videos/lessons/video')->getPathName();

          $dataVideo = [
            'video_url' => $video_url,
            'lesson_id' => $lesson->id,
            'filename' => $request->video_filename,
            'extension' => $request->video_extension,
            'duration' => $request->video_duartion
          ];

          $this->lessonVideo->create($dataVideo);

        }

        if ($request->has('file_url')) {
          $files = $request->file_url;
          $filenames = $request->file_filename;
          $extensions = $request->file_extension;
          $filesData = [];

          $lenght = count($files);

          for ($i = 0; $i < $lenght; $i++) {
            $file_url = gettype($files[$i]) == 'string'
              ? $files[$i]
              : $this->SaveDocument($files[$i], 'documents/lessons/file')->getPathName();

            $filesData[] = [
              'lesson_id' => $lesson->id,
              'file_url' => $file_url,
              'filename' => $filenames[$i],
              'extension' => $extensions[$i],
              'created_at' => now(),
              'updated_at' => now()
            ];
          }

          LessonFile::insert($filesData);
        }



        DB::commit();
        return response()->json([
          'status' => true,
          'message' => 'Lesson Create Successfully',
          'data' => new LessonResource($lesson)
        ]);
      } else {
        DB::rollBack();
        return response()->json([
          'status' => false,
          'message' => 'Lesson Create Failed',
        ]);
      }
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function update(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'lesson_id' => 'required|exists:lessons,id',
      'title' => 'required',
      'description' => 'required',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {
      $lesson = $this->lesson->find($request->lesson_id);
      if (is_null($lesson)) {
        return response()->json([
          "status" => false,
          "message" => "Course not found."
        ], 404);
      }
      $lesson = $this->lesson->update($request->lesson_id, $request->except(['lesson_id']));
      if (!$lesson) {
        return response()->json([
          'status' => false,
          'message' => 'Lesson Update Failed',
        ]);
      } else {
        return response()->json([
          'status' => true,
          'message' => 'Lesson Update Successfully',
          'data' => new LessonResource($lesson)
        ]);
      }
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function delete(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'lesson_id' => 'required|exists:lessons,id',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {
      $lesson = $this->lesson->delete($request->lesson_id);

      if (!$lesson) {
        return response()->json([
          'status' => false,
          'message' => 'Lesson Not Found',
        ]);
      } else {
        return response()->json([
          'status' => true,
          'message' => 'Lesson Deleted Successfully',
        ]);
      }

    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }

  }
}

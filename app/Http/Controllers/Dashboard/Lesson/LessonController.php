<?php

namespace App\Http\Controllers\Dashboard\Lesson;

use Exception;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonFile;
use App\Models\LessonVideo;
use Illuminate\Http\Request;
use App\Http\Traits\uploadFile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Lesson\LessonResource;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Handler\DropZoneUploadHandler;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;

class LessonController extends Controller
{
  use uploadFile;
  public function index($id, Request $request)
  {
    try {
      $course = Course::findOrFail($id);
      $lessons = $course->lessons();

      if ($request->search) {
        $lessons = $lessons->where('title', 'like', '%' . $request->search . '%')
          ->orWhere('description', 'like', '%' . $request->search . '%');
      }

      $lessons = $lessons->paginate(10);
      return view('dashboard.lesson.index', compact('course', 'lessons'));
    } catch (Exception $e) {
      return redirect()->route('error');
    }
  }

  public function create(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'course_id' => 'required|exists:courses,id',
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
      // ** create a new data for lesson if necessary
      $lesson = Lesson::create($request->only(['course_id', 'title', 'description']));

      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => $lesson
      ]);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function upload_video(Request $request)
  {
    // create the file receiver
    $receiver = new FileReceiver($request->video, $request, DropZoneUploadHandler::class);

    // check if the upload is success, throw exception or return response you need
    if ($receiver->isUploaded() === false) {
      throw new UploadMissingFileException();
    }

    // receive the file
    $save = $receiver->receive();

    // check if the upload has finished (in chunk mode it will send smaller files)
    if ($save->isFinished()) {
      $video = $save->getFile();
      $extension = $video->getClientOriginalExtension();
      $filename = $video->getClientOriginalName();
      $basename = basename($filename, '.' . $extension);
      $video_url = $video->move('videos/lessons/video', $basename . time() . '.' . $extension);
      LessonVideo::create([
        'lesson_id' => $request->lesson_id,
        'video_url' => $video_url,
        'filename' => $basename,
        'extension' => $extension,
      ]);

      return response()->json([
        'status' => true,
        'message' => 'Video uploaded successfully',
      ]);
    }


  }

  public function upload_files(Request $request)
  {//dd($request->files->all()['files']);
    $files = $request->files->all()['files'];
    $filesData = [];

    foreach ($files as $file) {
      $extension = $file->getClientOriginalExtension();
      $basename = basename($file->getClientOriginalName(), '.' . $extension);
      $filename = $basename . time() . '.' . $extension;
      $path = 'documents/lessons/file/';
      $file_url = $path . $filename;
      Storage::disk('upload')->putFileAs($path, $file,$filename);

      $filesData[] = [
        'lesson_id' => $request->lesson_id,
        'file_url' => $file_url,
        'filename' => $basename,
        'extension' => $extension,
        'created_at' => now(),
        'updated_at' => now()
      ];
    }

    LessonFile::insert($filesData);





  return response()->json([
    'status' => true,
    'message' => 'Files Uploaded Successfully',
  ]);


  }
}

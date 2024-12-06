<?php

namespace App\Http\Controllers\User\Lesson;

use Session;
use Exception;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonFile;
use App\Models\LessonVideo;
use Illuminate\Http\Request;
use App\Http\Traits\uploadFile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
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
      $user = auth()->user();

      if ($course->teacher->user_id != $user->id) {
        throw new Exception();
      }

      $lessons = $course->lessons();

      if ($request->search) {
        $lessons = $lessons->where('title', 'like', '%' . $request->search . '%')
          ->orWhere('description', 'like', '%' . $request->search . '%');
      }

      $lessons = $lessons->paginate(10);
      return view('user.lesson.index', compact('course', 'lessons'));
    } catch (Exception $e) {
      return redirect()->route('error');
    }
  }

  public function create($id)
  {

    try{

      $course = Course::whereNot('status','Refused')->findOrFail($id);

      if (auth()->user()?->teacher?->id != $course->teacher_id) {
        throw new Exception();
      }

      return view('user.lesson.create', compact('course'));

    }catch(Exception $e){
      return redirect()->route('error');
    }


  }

  public function store(Request $request)
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
      //$lesson = Lesson::create($request->only(['course_id', 'title', 'description']));

      $lesson = new Lesson();
      $lesson->course_id = $request->course_id;
      $lesson->title = $request->title;
      $lesson->description = $request->description;

      Session::put('lesson', $lesson);

      return response()->json([
        'status' => true,
        'message' => 'success',
      ]);

    } catch (Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function delete(Request $request)
  {

    try {
      $lesson = Lesson::with('course', 'files', 'videos')->find($request->id);
      $user = auth()->user();

      if ($lesson->course->teacher->user_id != $user->id) {
        throw new Exception(trans('message.prohibited'));
      }

      File::delete($lesson->videos->pluck('video_url'));
      File::delete($lesson->files->pluck('file_url'));

      $lesson->videos()->delete();
      $lesson->files()->delete();

      $lesson->delete();

      toastr()->success(trans('message.success.delete'));
      return redirect()->back();
    } catch (Exception $e) {
      toastr()->error($e->getMessage());
      return redirect()->back();
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

      $lesson = session('lesson');
      $lesson->save();
      Session::put('lesson', $lesson);

      LessonVideo::create([
        'lesson_id' => $lesson->id,
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
    $lesson = session('lesson');

    foreach ($files as $file) {
      $extension = $file->getClientOriginalExtension();
      $basename = basename($file->getClientOriginalName(), '.' . $extension);
      $filename = $basename . time() . '.' . $extension;
      $path = 'documents/lessons/file/';
      $file_url = $path . $filename;
      Storage::disk('upload')->putFileAs($path, $file, $filename);

      $filesData[] = [
        'lesson_id' => $lesson->id,
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

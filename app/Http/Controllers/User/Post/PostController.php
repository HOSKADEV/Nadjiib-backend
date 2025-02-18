<?php

namespace App\Http\Controllers\User\Post;

use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\DropZoneUploadHandler;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;

class PostController extends Controller
{
  public function index(Request $request)
  {
    $user = auth()->user();

    try {

      if (empty($user->teacher)) {
        throw new Exception();
      }

      $posts = $user->teacher->posts()->latest()->withCount('comments', 'likes');

      if ($request->search) {
        $lessons = $posts->where(function ($query) use ($request) {
          $query->where('title', 'like', '%' . $request->search . '%')
            ->orWhere('description', 'like', '%' . $request->search . '%');
        });
      }

      $posts = $posts->paginate(10)->appends($request->all());

      return view('user.post.index', compact('posts'));



    } catch (Exception $e) {
      return redirect()->route('error');
    }


  }

  public function store(Request $request){
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
      $video_url = $video->move('videos/posts/video', $basename . time() . '.' . $extension);


      Post::create([
        'teacher_id' => auth()->user()->teacher->id,
        'video_url' => $video_url,
        'description' => $request->description,
      ]);



      return response()->json([
        'status' => true,
        'message' => 'Post stored successfully',
      ]);
    }
  }

  public function delete(Request $request)
  {

    try {
      $post = Post::find($request->id);
      $user = auth()->user();

      if (!$user->isAdmin()) {
        throw new Exception(trans('message.prohibited'));
      }

      File::delete($post->video_url);

      $post->delete();

      toastr()->success(trans('message.success.delete'));
      return redirect()->back();
    } catch (Exception $e) {
      toastr()->error($e->getMessage());
      return redirect()->back();
    }


  }
}

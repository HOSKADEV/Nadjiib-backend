<?php

namespace App\Http\Controllers\Dashboard\Post;

use Exception;
use App\Models\Post;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function index(Request $request){

      $posts = Post::latest()->with('teacher')
      ->withCount('comments','likes');
      $teachers = Teacher::has('posts')->get();

      if ($request->teacher) {
        $lessons = $posts->where('teacher_id',$request->teacher);
      }

      if ($request->search) {
        $lessons = $posts->where(function ($query) use ($request) {
          $query->where('title', 'like', '%' . $request->search . '%')
            ->orWhere('description', 'like', '%' . $request->search . '%');
        });
      }

      $posts = $posts->paginate(10)->appends($request->all());

      return view('dashboard.post.index',compact('posts','teachers'));
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

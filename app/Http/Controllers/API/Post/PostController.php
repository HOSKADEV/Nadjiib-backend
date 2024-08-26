<?php

namespace App\Http\Controllers\API\Post;

use Exception;
use App\Models\Post;
use App\Models\Teacher;
use App\Models\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Traits\uploadFile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Post\PaginatedPostCollection;

class PostController extends Controller
{
  use uploadFile;
  public function create(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'teacher_id' => 'required|exists:teachers,id',
      'title' => 'sometimes|string',
      'description' => 'required',
      'video' => 'required',
      'thumbnail' => 'required',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {

      $post = Post::create($request->only('teacher_id','title','description'));

      $pathThumbnail = $this->SaveImage($request->thumbnail, 'images/posts/thumbnail/');
      $pathVideo = $this->SaveVideo($request->video, 'videos/posts/video/');

      $post->thumbnail = $pathThumbnail;
      $post->video_url = $pathVideo;
      $post->save();

      if($post->is_complement()){
        $teacher = $post->teacher;
        if($teacher->community_tasks_completed()){
          $teacher_purchases = $teacher->purchases()->where(DB::raw('DATE(purchases.created_at)'), '>=', Carbon::now()->startOfMonth())
            ->where(DB::raw('DATE(purchases.created_at)'), '<=', Carbon::now()->endOfMonth())->where('purchases.status','success')->get();

            foreach($teacher_purchases as $purchase){
              $purchase->apply_bonuses($teacher,null);
            }
        }

      }

      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => new PostResource($post)
      ]);

    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function update(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'post_id' => 'required|exists:posts,id',
      'title' => 'sometimes|string',
      'description' => 'sometimes',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {

      $post = Post::find($request->post_id);

      $post->update($request->all());

      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => new PostResource($post)
      ]);

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
      'post_id' => 'required|exists:posts,id',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {

      $post = Post::find($request->post_id);

      $post->delete();

      return response()->json([
        'status' => true,
        'message' => 'success',
      ]);

    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function restore(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'post_id' => 'required',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {

      $post = Post::withTrashed()->findOrFail($request->post_id);

      $post->restore();

      return response()->json([
        'status' => true,
        'message' => 'success',
      ]);

    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function get(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'teacher_id' => 'required|exists:teachers,id',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {

      $user = $this->get_user_from_token($request->bearerToken());
      $request->merge(['user' => $user]);

      $teacher = Teacher::find($request->teacher_id);

      $posts = $teacher->posts()->latest()->paginate(10);

      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => new PaginatedPostCollection($posts)
      ]);

    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function like(Request $request){
    $validation = Validator::make($request->all(), [
      'post_id' => 'required|exists:posts,id',
      'student_id' => 'required|exists:students,id',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {

      $like = PostLike::where($request->all())->first();

      if($like){
        $like->delete();
      }else{
        PostLike::create($request->all());
      }

      return response()->json([
        'status' => true,
        'message' => 'success',
      ]);

    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

}

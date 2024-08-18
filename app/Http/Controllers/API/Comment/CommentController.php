<?php

namespace App\Http\Controllers\API\Comment;

use Exception;
use App\Models\Post;
use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Comment\PaginatedCommentCollection;

class CommentController extends Controller
{
  public function create(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'post_id' => 'required|exists:posts,id',
      'student_id' => 'required|exists:students,id',
      'content' => 'required',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {

      $comment = Comment::create($request->all());

      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => new CommentResource($comment)
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
      'comment_id' => 'required|exists:comments,id',
      'content' => 'sometimes|string',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {

      $comment = Comment::find($request->comment_id);

      $comment->update($request->all());

      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => new CommentResource($comment)
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
      'comment_id' => 'required|exists:comments,id',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {

      $comment = Comment::find($request->comment_id);

      $comment->delete();

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
      'comment_id' => 'required',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {

      $comment = Comment::withTrashed()->findOrFail($request->comment_id);

      $comment->restore();

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

      $comments = $post->comments()->latest()->paginate(10);

      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => new PaginatedCommentCollection($comments)
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
      'comment_id' => 'required|exists:comments,id',
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

      $like = CommentLike::where($request->all())->first();

      if($like){
        $like->delete();
      }else{
        CommentLike::create($request->all());
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

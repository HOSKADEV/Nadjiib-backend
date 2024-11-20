<?php

namespace App\Http\Controllers\API\Following;

use Exception;
use App\Models\User;
use App\Models\Following;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\PaginatedUserCollection;

class FollowingController extends Controller
{
  public function create(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'teacher_id' => 'required|exists:teachers,id',
      //'student_id' => 'required|exists:students,id',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {

      $student = auth()->user()?->student;

      if (empty($student)) {
        throw new Exception('no student found');
      }

      $request->merge(['student_id' => $student->id]);

      $following = Following::where($request->all())->first();

      if ($following) {
        $following->delete();
      } else {
        Following::create($request->all());
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

  public function get(Request $request)
  {

    try {

      $user = auth()->user();

      $request->merge(['user' => $user]);

      $student = $user?->student;


      if (empty($student)) {
        throw new Exception('no student found');
      }

      /* $followings = $user->student?->followed_teachers()->get(['user_id'])->pluck('user_id')->toArray();

      $teachers = User::where('status','ACTIVE')
                        ->where('role', '2')
                        ->whereIn('id',$followings); */

      $teachers = User::join('teachers', 'users.id', 'teachers.user_id')
        ->join('followings',function($join) use ($student){
            $join->on( 'teachers.id', '=', 'followings.teacher_id');
            $join->where('followings.student_id', '=', $student->id);
        })
        ->select('users.*')
        ->where('users.status', 'ACTIVE')
        ->where('users.role', '2')
        ->orderBy('followings.created_at', 'DESC');


      return response()->json([
        'status' => true,
        'data' => new PaginatedUserCollection($teachers->paginate(10))
      ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }
}

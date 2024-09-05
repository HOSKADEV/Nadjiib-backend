<?php

namespace App\Http\Controllers\API\Chat;

use Exception;
use App\Models\Chat;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\User\PaginatedUserCollection;

class ChatController extends Controller
{
  public function create(Request $request){
    $validation = Validator::make($request->all(), [
      'teacher_id' => 'required|exists:users,id',
      'student_id' => 'required|exists:users,id',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {

      $teacher_id = Teacher::where('user_id',$request->teacher_id)->first()?->id;

      $student_id = Student::where('user_id',$request->student_id)->first()?->id;

      if(empty($teacher_id) || empty($student_id)){
        throw new Exception('invalid users');
      }

      $chat = Chat::firstOrCreate([
        'teacher_id' => $teacher_id,
        'student_id' => $student_id,
      ]);


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

public function get(Request $request){


  try
  {

  $user = auth()->user();

  $chats = Chat::join('students', 'chats.student_id', 'students.id')
      ->join('teachers', 'chats.teacher_id', 'teachers.id')
/*       ->join('subscriptions' , 'subscriptions.student_id' , 'students.id')
      ->join('purchases' , 'subscriptions.purchase_id' , 'purchases.id')
      ->join('courses' , function($join){
        $join->on('courses.id', '=', 'purchases.course_id');
        $join->on('chats.teacher_id', '=', 'courses.teacher_id');
      })
    ->Where(function ($query){
      return $query->where(DB::raw('DATE(subscriptions.start_date)'), '<=', Carbon::now())
      ->where(DB::raw('DATE(subscriptions.end_date)'), '>=', Carbon::now());
    }) */
    ->Where(function ($query) use ($user) {
      return $query->where('chats.student_id', $user?->student?->id)
      ->orWhere('chats.teacher_id', $user?->teacher?->id);
    })


    ->select('students.user_id AS student_id', 'teachers.user_id AS teacher_id')->get();

    $user_ids = array_merge($chats->pluck('student_id')->toArray(), $chats->pluck('teacher_id')->toArray());

  $users = User::where('status','ACTIVE')
  ->whereIn('id',$user_ids)
  ->WhereNot('id',$user->id);

    return response()->json([
      'status' => true,
      'data'   => new PaginatedUserCollection($users->paginate(10))
    ]);
  }
  catch(Exception $e)
  {
    return response()->json([
      'status'  => false,
      'message' => $e->getMessage()
    ]);
  }
}
}

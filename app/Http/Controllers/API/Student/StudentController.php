<?php

namespace App\Http\Controllers\API\Student;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Student\StudentRepository;
use App\Http\Resources\Student\StudentCollection;
use App\Http\Resources\Student\PaginateStudentCollection;

class StudentController extends Controller
{
  private $student;
  private $user;

  public function __construct(StudentRepository $student, UserRepository $user)
  {
    $this->student = $student;
    $this->user = $user;
  }

  public function create(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|exists:users,id',
      'level_id' => 'required|exists:levels,id',
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => false,
          'message' => $validator->errors()->first()
        ]
      );
    }

    try {

      $studentexists =  $this->student->studentExists($request->user_id);

      if (!$studentexists) {
        $student = $this->student->create($request->all());
        $user = $this->user->find($request->user_id);
        return response()->json([
          'status' => true,
          'data'   => new UserResource($user)
        ]);
      }
      else {
        return response()->json([
          'status' => false,
          'message' => 'Sorry, but you have already created an account.',
        ]);
      }

    } catch (Exception $e) {
      return response()->json([
        'status'  => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function update(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'student_id' => 'required|exists:students,id',
      'level_id'   => 'sometimes|exists:levels,id',
      "name"       => 'sometimes|string',
      "image"      => 'sometimes|string',
      "phone"      => 'sometimes|unique:users,phone',
      "gender"     => 'sometimes|in:male,female'
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'status'  => false,
          'message' => $validator->errors()->first()
        ]
      );
    }

    try {
      $studentFind = $this->student->find($request->student_id);
      if (is_null($studentFind)) {
          return response()->json([
            'status' => false,
            'message' => 'Sorry, This student does not exist.',
          ]);
      }
      $student = $this->student->update($request->student_id, $request->only('level_id'));

      $user = $this->user->update($student->user_id,$request->except(['student_id','level_id']));

      return response()->json([
        'status' => true,
        'data'   => new UserResource($user)
      ]);
    } catch (Exception $e) {
      return response()->json([
        'status'  => false,
        'message' => $e->getMessage()
      ]);
    }
  }

}

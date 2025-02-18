<?php

namespace App\Http\Controllers;

use App\Models\CompletedLesson;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompletedLessonController extends Controller
{
  public function create(Request $request)
  {
    $validtion = Validator::make($request->all(), [
      'lesson_id' => 'required|exists:lessons,id',
    ]);
    if ($validtion->fails()) {
      return response()->json([
        "status" => false,
        "errors" => $validtion->errors()
      ], 403);
    }

    try {

      $user = $request->user();

      $student = $user?->student;


      if(empty($student)){
        throw new Exception('no student found');
      }

      CompletedLesson::create([
        'student_id' => $student->id,
        'lesson_id' =>  $request->lesson_id
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


}

<?php

namespace App\Http\Controllers\API\Call;

use Exception;
use App\Models\Call;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Call\CallResource;
use Illuminate\Support\Facades\Validator;

class CallController extends Controller
{
    public function create(Request $request){
      $validation = Validator::make($request->all(), [
        'teacher_id' => 'required|exists:users,id',
        'student_id' => 'required|exists:users,id',
        'start_time' => 'required|date',
        'end_time' => 'required|date',
        'duration' => 'sometimes',
        'rating' => 'sometimes|in:like,dislike',
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


        $duplicate_call = Call::where('student_id', $student_id)->where('teacher_id',$teacher_id)
        ->Where(function ($query) use ($request) {
          return $query->where(DB::raw("ABS(TIMEDIFF(start_time, '".$request->start_time."'))"), '<', 60)
                    ->orWhere(DB::raw("ABS(TIMEDIFF(end_time, '".$request->end_time."'))"), '<', 60);
        })->first();

        if(empty($duplicate_call)){

          $request->merge([
            'teacher_id' => $teacher_id,
            'student_id' => $student_id,
          ]);

          $call = Call::create($request->all());

          $call->refresh();

          if($call->is_complement()){
            $teacher = $call->teacher;
            if($teacher->cloud_tasks_completed()){
              $teacher_purchases = $teacher->purchases()->where(DB::raw('DATE(purchases.created_at)'), '>=', Carbon::now()->startOfMonth())
                ->where(DB::raw('DATE(purchases.created_at)'), '<=', Carbon::now()->endOfMonth())->where('purchases.status','success')->get();

                foreach($teacher_purchases as $purchase){
                  $purchase->apply_bonuses($teacher,null);
                }
            }

          }
        }

        return response()->json([
          'status' => true,
          'message' => 'success',
          //'data' => new CallResource($call)
        ]);

      } catch (Exception $e) {
        return response()->json([
          'status' => false,
          'message' => $e->getMessage()
        ]);
      }
    }

    public function update(Request $request){
      $validation = Validator::make($request->all(), [
        'call_id' => 'required|exists:calls,id',
        'start_time' => 'sometimes|date',
        'end_time' => 'sometimes|date',
        'duration' => 'sometimes',
        'rating' => 'sometimes|in:like,dislike',
      ]);

      if ($validation->fails()) {
        return response()->json([
          'status' => false,
          'message' => 'Invalid data sent',
          'errors' => $validation->errors()
        ], 422);
      }

      try {

        $call = Call::find($request->call_id);

        $call->update($request->all());

        $call->refresh();

        if($call->is_complement()){
          $teacher = $call->teacher;
          if($teacher->cloud_tasks_completed()){
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
          'data' => new CallResource($call)
        ]);

      } catch (Exception $e) {
        return response()->json([
          'status' => false,
          'message' => $e->getMessage()
        ]);
      }
    }
}

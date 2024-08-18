<?php

namespace App\Http\Controllers\API\Call;

use Exception;
use App\Models\Call;
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
        'teacher_id' => 'required|exists:teachers,id',
        'student_id' => 'required|exists:students,id',
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

        $call = Call::create($request->all());

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
          'data' => new CallResource($call->refresh())
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

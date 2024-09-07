<?php

namespace App\Http\Controllers\Dashboard\Teacher;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Teacher\TeacherRepository;

class TeacherController extends Controller
{
  private $teacher;
  private $user;
  private $coupon;

  public function __construct(TeacherRepository $teacher, UserRepository $user, CouponRepository $coupon)
  {
    $this->teacher = $teacher;
    $this->user = $user;
    $this->coupon = $coupon;
  }

  public function changeStatus(Request $request)
  {
      $teacher = $this->teacher->find($request->id);
      $teacher->update(['status' => !boolval($teacher->status)]);
      toastr()->success(trans('message.success.update'));
      return redirect()->route('dashboard.users.index');
  }

 /*  public function create(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|exists:users,id',
      "name" => 'sometimes|string',
      "phone" => 'sometimes|unique:users,phone',
      "channel_name" => 'required|string',
      "bio" => 'sometimes|string',
      "cloud_chat" => 'sometimes|in:active,inactive',
      "sections" => 'required|array',
      "subjects" => 'required|array',
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

      DB::beginTransaction();

      $coupon = $this->coupon->generate();

      $request->merge(['coupon_id' => $coupon->id]);

      $this->teacher->create(
        $request->only(['user_id', 'coupon_id', 'channel_name','bio','cloud_chat']),
        $request->sections,
        $request->subjects);

      $request->merge(['role' => '2']);

      $user = $this->user->update($request->user_id, $request->only(['name','phone','role']));

      DB::commit();

      return response()->json([
        'status' => true,
        'data' => new UserResource($user)
      ]);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function update(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'teacher_id' => 'required|exists:teachers,id',
      "name" => 'sometimes|string',
      "image" => 'sometimes|string',
      "phone" => 'sometimes|unique:users,phone',
      "channel_name" => 'sometimes|string',
      "bio" => 'sometimes|string',
      "cloud_chat" => 'sometimes|in:active,inactive',
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

      $teacher = $this->teacher->update($request->teacher_id, $request->only(['channel_name','bio','cloud_chat']));

      $user = $this->user->update($teacher->user_id, $request->only(['name','image','phone']));

      return response()->json([
        'status' => true,
        'data' => new UserResource($user)
      ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  } */
}

<?php

namespace App\Http\Controllers\API\Teacher;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Teacher\TeacherRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
    public function create(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id',
        "name"    => 'sometimes|string',
        "phone"   => 'sometimes|unique:users,phone',
        "channel_name" => 'required|string',
        "bio"   => 'sometimes|string',
        "cloud_chat" => 'sometimes|in:active,inactive',
        "sections"   => 'required|array',
        "subjects"   => 'required|array',
      ]);

      if ($validator->fails()) {
        return response()->json(
          [
            'status' => 0,
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

        $user = $this->user->update($request->user_id, $request->only(['name','phone']));

        DB::commit();

        return response()->json([
          'status' => 1,
          'data' => new UserResource($user)
        ]);
      } catch (Exception $e) {
        DB::rollBack();
        return response()->json([
          'status' => 0,
          'message' => $e->getMessage()
        ]);
      }
    }

    public function update(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'teacher_id'  => 'required|exists:teachers,id',
      "name"        => 'sometimes|string',
      "image"       => 'sometimes|string',
      "phone"       => 'sometimes|unique:users,phone',
      "channel_name" => 'sometimes|string',
      "bio"         => 'sometimes|string',
      "cloud_chat"  => 'sometimes|in:active,inactive',
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => 0,
          'message' => $validator->errors()->first()
        ]
      );
    }

    try {

      $teacher = $this->teacher->update($request->teacher_id, $request->only(['channel_name','bio','cloud_chat']));

      $user = $this->user->update($teacher->user_id, $request->only(['name','image','phone']));

      return response()->json([
        'status' => 1,
        'data' => new UserResource($user)
      ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => 0,
        'message' => $e->getMessage()
      ]);
    }
  }
}

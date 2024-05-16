<?php

namespace App\Http\Controllers\API\Teacher;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
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
    public function create(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id',
        "name"    => 'sometimes|string',
        "phone"   => 'sometimes|unique:users,phone',
        "channel_name" => 'required|string',
        "bio"   => 'sometimes|string',
        "sections"   => 'required|array',
        "subjects"   => 'required|array',
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
        $teacherExists = $this->teacher->teacherExists($request->user_id);
        if ($teacherExists) {
          return response()->json([
            'status' => false,
            'message' => 'Sorry, but you have already created an account.',
          ]);
        }
        DB::beginTransaction();

        $coupon = $this->coupon->generate();

        $request->merge(['coupon_id' => $coupon->id]);


        $this->teacher->create(
          $request->only(['user_id', 'coupon_id','bio','channel_name']),
          $request->sections,
          $request->subjects
        );
        $dataUser = array_replace([
          'name'  => $request->name,
          'phone' => $request->phone,
          'role'=> 2
        ]);
        $user = $this->user->update($request->user_id, $dataUser);

        DB::commit();

        return response()->json([
          'status' =>true,
          'data' => new UserResource($user)
        ]);
      } catch (Exception $e) {
        DB::rollBack();
        return response()->json([
          'status'  => false,
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
        $teacherFind = $this->teacher->find($request->teacher_id);
        if (is_null($teacherFind)) {
            return response()->json([
              'status' => false,
              'message' => 'Sorry, This teacher does not exist.',
            ]);
        }
        $teacher = $this->teacher->update($request->teacher_id, $request->only(['channel_name','bio']));

        $user = $this->user->update($teacher->user_id, $request->only(['name','image','phone']));

        return response()->json([
          'status' => true,
          'data' => new UserResource($user)
        ]);
      } catch (Exception $e) {
        return response()->json([
          'status'  => false,
          'message' => $e->getMessage()
        ]);
      }
    }
}

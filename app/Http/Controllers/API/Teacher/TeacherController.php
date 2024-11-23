<?php

namespace App\Http\Controllers\API\Teacher;

use Exception;
use App\Models\User;
use App\Models\Level;
use App\Models\Teacher;
use App\Models\LevelSubject;
use Illuminate\Http\Request;
use App\Models\TeacherSection;
use App\Models\TeacherSubject;
use App\Http\Traits\uploadFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Resources\User\UserResource;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\User\UserCollection;
use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Teacher\TeacherRepository;
use App\Http\Resources\Subject\SubjectCollection;

class TeacherController extends Controller
{
    private $teacher;
    private $user;
    private $coupon;
    use uploadFile;

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
        "cloud_chat" => 'required|in:active,inactive',
        "bio"   => 'sometimes|string',
        "sections"   => 'required|array',
        "subjects"   => 'required|array',
        "ccp" => 'sometimes|string',
        "baridi_mob" => 'sometimes|string',
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

        $user = User::findOrFail($request->user_id);

        $request->merge(['coupon_id' => $coupon->id]);


        $this->teacher->create(
          $request->only(['user_id', 'coupon_id','bio','channel_name','cloud_chat']),
          $request->sections,
          $request->subjects
        );
        $dataUser = array_replace([
          'name'  => $request->name?? $user->name,
          'phone' => $request->phone?? $user->phone,
          'ccp'  => $request->ccp?? $user->ccp,
          'baridi_mob' => $request->baridi_mob?? $user->baridi_mob,
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
          "image"       => 'sometimes|mimes:jpeg,png,jpg,gif',
          "phone"       => 'sometimes|unique:users,phone',
          "gender"     => 'sometimes|in:male,female',
          "channel_name" => 'sometimes|string',
          "cloud_chat" => 'sometimes|in:active,inactive',
          "bio"         => 'sometimes|string',
          "ccp" => 'sometimes|string',
          "baridi_mob" => 'sometimes|string',
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

        $userFind = $this->user->find($teacherFind->user_id);
        $imageTeacher = $userFind->image;
      if ($request->has('image')) {
        if ($imageTeacher != null && File::exists($imageTeacher)) {
          // !! Delete image from public folder
          File::delete($imageTeacher);
          // ** Save new image in public folder and return path image save
        }

          // ** Save new image in public folder and return path image save
          $pathImage = $this->SaveImage($request->image , 'images/teachers/image/')->getPathName();

      }
      else {
        // ** retun the same image
        $pathImage = $imageTeacher;
      }



      $teacher = $this->teacher->update($request->teacher_id, $request->only(['channel_name','bio','cloud_chat']));
      $user = $this->user->update($teacher->user_id, $request->only('name','phone','gender','ccp','baridi_mob'));
      $user->image = $pathImage;
      $user->save();

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

    public function get(Request $request){

      $validator = Validator::make($request->all(), [
        'sections' => 'sometimes|array',
        'sections.*' => 'exists:sections,id',
        'subjects' => 'sometimes|array',
        'subjects.*' => 'exists:subjects,id',
        'type'      => 'sometimes|in:cloud_chat,channels,most_active',
        'search'    => 'sometimes|string',
      ]);

      if ($validator->fails()) {
        return response()->json(
          [
            'status'  => false,
            'message' => $validator->errors()->first()
          ]
        );
      }

      try
      {

        $user = $this->get_user_from_token($request->bearerToken());

        /* $request->mergeIfMissing([
          'subjects' => $user?->student?->active_subs()->pluck('subject_id')->toArray() ?? []
        ]); */

        $teachers = User::join('teachers','users.id','teachers.user_id')
                        ->leftjoin('posts','teachers.id','posts.teacher_id')
                        ->groupBy('teachers.id')
                        ->select('users.*',
                        'teachers.id as teacher_id',
                        'teachers.bio',
                        'teachers.cloud_chat',
                        'teachers.channel_name',
                        DB::raw('COUNT(posts.id) as num_posts'))
                        ->where('users.status','ACTIVE')
                        ->where('teachers.status',1)
                        ->where('role', '2');

        //return($teachers->get());

        if($user){
          $teachers = $teachers->whereNot('users.id',$user->id);
        }

        if($request->has('type')){
          if($request->type == 'cloud_chat'){
            $teachers = $teachers->where('cloud_chat', 'ACTIVE')->orderBy('teachers.created_at', 'DESC');
            $request->mergeIfMissing([
              'subjects' => $user?->student?->active_subs()->pluck('subject_id')->toArray() ?? []
            ]);
          }
          if($request->type == 'channels'){
            $teachers = $teachers->having('num_posts','>', 0)->orderBy('teachers.created_at', 'DESC');
          }
          if($request->type == 'most_active'){
            $teachers = $teachers->having('num_posts','>', 0)->orderBy('num_posts', 'DESC');
          }

        }else{
          $teachers = $teachers->orderBy('users.created_at', 'DESC');
        }

        if($request->has('subjects')){
          $teacher_ids = TeacherSubject::whereIn('subject_id',$request->subjects)->distinct('teacher_id')->pluck('teacher_id')->toArray();
          $teachers = $teachers->whereIn('teachers.id', $teacher_ids);
        }

        if($request->has('sections')){
          $teacher_ids = TeacherSection::whereIn('section_id',$request->sections)->distinct('teacher_id')->pluck('teacher_id')->toArray();
          $teachers = $teachers->whereIn('teachers.id', $teacher_ids);
        }


        if($request->has('search')){
          $teachers = $teachers->where(function ($query) use($request) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('bio', 'like', '%' . $request->search . '%')
                ->orWhere('channel_name', 'like', '%' . $request->search . '%');
        });

        }



        return response()->json([
          'status' => true,
          'data'   => new UserCollection($teachers->paginate(10))
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

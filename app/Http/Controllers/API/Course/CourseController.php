<?php

namespace App\Http\Controllers\API\Course;

use App\Http\Resources\Course\CourseInfoResource;
use Exception;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Traits\uploadFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Course\CourseResource;
use App\Repositories\Course\CourseRepository;
use App\Http\Resources\Wishlist\WishlistCollection;
use App\Http\Resources\Course\PaginateCourseCollection;
use App\Repositories\CourseLevel\CourseLevelRepository;
use App\Repositories\CourseSection\CourseSectionRepository;

class CourseController extends Controller
{
  private $course;
  private $courseSection;
  private $courseLevel;
  use uploadFile;

  public function __construct(CourseRepository $course, CourseSectionRepository $courseSection, CourseLevelRepository $courseLevel)
  {
    $this->course = $course;
    $this->courseSection = $courseSection;
    $this->courseLevel = $courseLevel;
  }
  public function all(Request $request)
  {
    try {
      $validation = Validator::make($request->all(), [
        'search_byName' => 'sometimes|string',
        'search_bySubject' => 'sometimes|string',
        'search_byTeatcher' => 'sometimes|string',
      ]);

      if ($validation->fails()) {
        return response()->json([
          "status" => false,
          "errors" => $validation->errors()
        ], 403);
      }

      $searchByName = $request->search_byName;
      $searchBySubject = $request->search_bySubject;
      $searchByTeatcher = $request->search_byTeatcher;

      $course = $this->course->paginate(10, $searchByName, $searchBySubject, $searchByTeatcher);
      // $courses = $this->course->paginate($perPage = 10, $request->search, $request->subject, $request->teacher, $request->status);
      return response()->json([
        'status' => true,
        'data' => new PaginateCourseCollection($course)
      ], 201);
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }
  public function create(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'teacher_id' => 'required|exists:teachers,id',
      'subject_id' => 'sometimes|exists:subjects,id',
      'name' => 'required|string',
      'description' => 'required',
      'price' => 'required|numeric|min:0',
      'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
      'video' => 'required',
      'thumbnail' => 'required',
      'sections_ids' => 'required',
      'levels_ids' => 'sometimes',
      'name_subject' => 'sometimes',
      'type_subject' => 'sometimes|in:academic,extracurricular',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {
      $sections_ids = $request->input('sections_ids');
      $levels_ids = $request->input('levels_ids');
      // ** Save image in public folder and return path image save
      $pathImage = $this->SaveImage($request->image, 'images/courses/image/');
      $pathThumbnail = $this->SaveImage($request->thumbnail, 'images/courses/thumbnail/');
      $pathVideo = $this->SaveVideo($request->video, 'videos/courses/video/');

      // ** Verfication is has a new subject and Saved
      if ($request->has('name_subject')) {
        $subject = new Subject();
        $subject->name_ar = $request->name_subject;
        $subject->name_fr = $request->name_subject;
        $subject->name_en = $request->name_subject;
        $subject->type = $request->type_subject;
        $subject->save();
      }
      // ** data array append subject ID after save new  and iamge
      $data = array_replace($request->all(), [
        'subject_id' => $request->has('name_subject') != null ? $subject->id : $request->subject_id,
        'image' => $pathImage,
        'video' => $pathVideo,
        'thumbnail' => $pathThumbnail
      ]);
      // ** Save data to model Course
      $course = $this->course->create($data);
      // ** Sava sections IDs to model course section
      foreach ($sections_ids as $section_id) {
        $courseSection = $this->courseSection->create(['section_id' => $section_id, 'course_id' => $course->id]);
      }
      // ** verfication to has Levels IDs and sava to model level section
      if ($request->has('levels_ids')) {
        foreach ($levels_ids as $level_id) {
          $courseLevel = $this->courseLevel->create(['level_id' => $level_id, 'course_id' => $course->id]);
        }
      }
      if ($course) {
        return response()->json([
          'status' => true,
          'message' => 'The course has been created successfully',
          'data' => new CourseResource($course->refresh())
        ], 202);
      } else {
        return response()->json([
          "status" => false,
          "message" => "Error in the server when creating the course"
        ], 500);
      }

    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }

  }
  public function update(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'course_id' => 'required|exists:courses,id',
      'name' => 'required|string',
      'description' => 'required',
      'price' => 'required|numeric|min:0',
      'image' => 'sometimes|mimes:jpeg,png,jpg,gif,svg',
      'video' => 'sometimes',
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {
      // ** Get find course is exist or No
      $course = $this->course->find($request->course_id);
      if (!$course) {
        return response()->json([
          "status" => false,
          "message" => "Course not found."
        ], 404);
      } else {
        // ** Delete old image from folder when updating the course.
        $imageCourse = $course->image;
        $videoCourse = $course->video;
        if ($request->has('image')) {
          if ($imageCourse != null && File::exists($imageCourse)) {
            // !! Delete image from public folder
            File::delete($imageCourse);
            // ** Save new image in public folder and return path image save
            $pathImage = $this->SaveImage($request->image, 'images/courses/image/');
          } else {
            // ** Save new image in public folder and return path image save
            $pathImage = $this->SaveImage($request->image, 'images/courses/image/');
          }
        } else {
          // ** retun the same image
          $pathImage = $imageCourse;
        }
        if ($request->has('video')) {
          if ($videoCourse != null && File::exists($videoCourse)) {
            // !! Delete image from public folder
            File::delete($videoCourse);
            // ** Save new video in public folder and return path video save
            $pathVideo = $this->SaveVideo($request->video, 'videos/courses/video/');
          } else {
            // ** Save new video in public folder and return path video save
            $pathVideo = $this->SaveVideo($request->video, 'videos/courses/video/');
          }
        } else {
          // ** retun the same video
          $pathVideo = $videoCourse;
        }

        // ** data array append subject ID after save new  and iamge
        $data = array_replace($request->all(), [
          'image' => $pathImage,
          'video' => $pathVideo,
        ]);
        $courseupdate = $this->course->update($request->course_id, $data);
        if (!$courseupdate) {
          return response()->json([
            "status" => false,
            "message" => "Failed to update the course."
          ], 500);
        } else {
          return response()->json([
            "status" => true,
            "message" => "The Course has been updated.",
            "data" => new CourseResource($courseupdate)
          ], 201);
        }
      }
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function delete(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'course_id' => 'required|exists:courses,id'
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {
      $courseDelete = $this->course->delete($request->course_id);
      if (!$courseDelete) {
        return response()->json([
          'status' => false,
          'message' => 'Server Error. Can\'t delete the course at this time.',
        ], 500);
      } else {
        return response()->json([
          'status' => true,
          'message' => 'Course deleted successfully.'
        ]);
      }
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function get(Request $request)
  {

    $validation = Validator::make($request->all(), [
      'teacher_id' => 'sometimes|exists:teachers,id',
      'subject_id' => 'sometimes|exists:subjects,id',
      'type' => 'sometimes|in:best_sellers,suggestions,recommended,wishlist',
      'status' => 'sometimes|in:PENDING,ACCEPTED,REFUSED',
      'search' => 'sometimes|string',
    ]);

    if ($validation->fails()) {
      return response()->json([
        "status" => false,
        "errors" => $validation->errors()
      ], 403);
    }

    try{

      $user = $this->get_user_from_token($request->bearerToken());
      $request->merge(['user' => $user]);

      if ($request->has("type")) {
        if ($request->type == 'best_sellers') {
          $courses = new PaginateCourseCollection(Course::where('status', 'ACCEPTED')->inRandomOrder()->limit(10)->paginate(5));
        }
        if ($request->type == 'suggestions') {
          $courses = new PaginateCourseCollection(Course::where('status', 'ACCEPTED')->inRandomOrder()->limit(10)->paginate(5));
        }
        if ($request->type == 'recommended') {
          $courses = new PaginateCourseCollection(Course::where('status', 'ACCEPTED')->inRandomOrder()->limit(10)->paginate(5));
        }
        if ($request->type == 'wishlist') {
          $courses = new WishlistCollection($user?->student?->wishlists);
        }

        return response()->json([
          'status' => true,
          'data' => $courses
        ], 201);

      } else {

        if ($request->has('teacher_id') && $request->teacher_id == $user?->teacher?->id) {
          $courses = Course::orderBy('created_at', 'DESC')->where('status', $request->status?? 'ACCEPTED');
        } else {;
          $courses = Course::orderBy('created_at', 'DESC')->where('status', 'ACCEPTED');
        }

        if ($request->has('teacher_id')) {
          $courses = $courses->where('teacher_id', $request->teacher_id);
        }

        if ($request->has('subject_id')) {
          $courses = $courses->where('subject_id', $request->subject_id);
        }


        if ($request->has('search')) {
          $courses = $courses->Where(function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
          });
        }


        return response()->json([
          'status' => true,
          'data' => new PaginateCourseCollection($courses->paginate(5))
        ], 201);



      }
    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }

  }

  public function info(Request $request){
    $validation = Validator::make($request->all(), [
      'course_id' => 'required|exists:courses,id'
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => $validation->errors()->first(),
        //'message' => 'Invalid coupon',
        //'errors' => $validation->errors()
      ], 422);
    }

    try {

      $course = Course::find($request->course_id);
      $user = $this->get_user_from_token($request->bearerToken());
      $request->merge(['user' => $user]);

      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => new CourseInfoResource($course)
      ]);

    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }
}



<?php

namespace App\Http\Controllers\User\Course;

use Exception;
use App\Models\Section;
use App\Rules\NewSubject;
use App\Enums\CourseStatus;
use Illuminate\Http\Request;
use App\Rules\ValidSubjectName;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Course\CourseRepository;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\Teacher\TeacherRepository;

class CourseController extends Controller
{
  private $courses;
  private $teachers;
  private $subjects;

  /**
   * CourseController constructor.
   * @param CourseRepository $courses
   * @param TeacherRepository $teachers
   * @param SubjectRepository $subjects
   */
  public function __construct(CourseRepository $courses, TeacherRepository $teachers, SubjectRepository $subjects)
  {
    $this->courses = $courses;
    $this->teachers = $teachers;
    $this->subjects = $subjects;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $user = auth()->user();
    if (empty($user->teacher)) {
      return redirect()->route('error');
    }
    $subjects = $user->teacher->course_subjects;

    $courses = $user->teacher->courses();

    if ($request->subject) {
      $courses = $courses->where('subject_id', $request->subject);
    }

    if ($request->status) {
      $courses = $courses->where('status', $request->status);
    }

    if ($request->search) {
      $courses = $courses->where('name', 'like', "%{$request->search}%");
    }

    $courses = $courses->paginate(10);

    return view('user.course.index', compact('courses', 'subjects'));

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    if (auth()->user()?->teacher) {
      $sections = Section::with('levels')->get();
      return view('user.course.create',compact('sections'));
    } else {
      return redirect()->back();
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'name' => 'required|string',
      'description' => 'required',
      'price' => 'required|numeric|min:0',
      'type_subject' => 'required|in:academic,extracurricular',
      'subject_id' => 'required_if:type_subject,academic|exists:subjects,id',
      'sections_ids' => 'required_if:type_subject,extracurricular|array',
      'levels_ids' => 'required_if:type_subject,academic|array',
      'name_subject' => new ValidSubjectName($request),
    ]);

    if ($validation->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid data sent',
        'errors' => $validation->errors()
      ], 422);
    }

    try {

      Session::put('courseData', $request->all());

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

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $course = $this->courses->find($id);
    return view('dashboard.course.single', compact('course'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $data = [
      'status' => $request->status == 1 ? CourseStatus::ACCEPTED : CourseStatus::REFUSED,
      'reject_reason' => $request->reject_reason,
    ];
    $course = $this->courses->update($request->id, $data);
    $course->refresh();
    $course->notify();
    toastr()->success($request->status == 1 ? trans('message.success.approved') : trans('message.success.reject'));
    return redirect()->route('dashboard.courses.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $this->courses->delete($request->id);
    toastr()->success(trans('message.success.delete'));
    return redirect()->route('dashboard.courses.index');
  }
}

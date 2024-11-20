<?php

namespace App\Http\Controllers\Dashboard\Course;

use App\Enums\CourseStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $courses = $this->courses->paginate($perPage = 10, $request->search, $request->subject, $request->teacher, $request->status);
        $subjects = $this->subjects->all();
        $teachers = $this->teachers->all();
        return view('dashboard.course.index', compact('courses', 'teachers', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return view('dashboard.course.single',compact('course'));
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
            'reject_reason'=> $request->reject_reason,
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

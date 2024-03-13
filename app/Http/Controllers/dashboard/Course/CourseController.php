<?php

namespace App\Http\Controllers\Dashboard\Course;

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
        // public function paginate($perPage, $search = null, $subject = null, $teacher = null, $status = null)

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
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

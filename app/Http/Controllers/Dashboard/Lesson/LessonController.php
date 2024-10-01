<?php

namespace App\Http\Controllers\Dashboard\Lesson;

use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LessonController extends Controller
{
    public function index($id){
      try{
        $course = Course::findOrFail($id);
        $lessons = $course->lessons()->paginate(10);
        return view('dashboard.lesson.index', compact('course', 'lessons'));
      }catch(Exception $e){
        return redirect()->route('error');
      }
    }
}

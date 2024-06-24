<?php

namespace App\Http\Controllers\Dashboard\LevelSubject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Level\LevelRepository;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\LevelSubject\LevelSubjectRepository;
use App\Http\Requests\LevelSubject\StoreLevelSubjectRequest;

class LevelSubjectController extends Controller
{
    private $levelSubjects;
    private $levels;
    private $subjects;

    /**
     * LevelSubjectController constructor.
     * @param LevelSubjectRepository $levelSubjects
     * @param LevelRepository $levels
     * @param SubjectRepository $subjects
     */
    public function __construct(LevelSubjectRepository $levelSubjects , LevelRepository $levels,SubjectRepository $subjects)
    {
        $this->levelSubjects = $levelSubjects;
        $this->levels = $levels;
        $this->subjects = $subjects;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $levelSubjects = $this->levelSubjects->paginate($perPage = 10, $request->search);
        $levels = $this->levels->all();
        $subjects = $this->subjects->all();
        return view('dashboard.levelsubject.index',compact('levelSubjects','levels','subjects'));
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
    public function store(StoreLevelSubjectRequest $request)
    {
        $data = [];
        foreach ($request->list_level_subjects as $list_level_subject) {
            $data['level_id'] = $list_level_subject['level'];
            $data['subject_id'] = $list_level_subject['subject'];
            $this->levelSubjects->create($data);
        }
        toastr()->success(trans('message.success.create'));
        return redirect()->route('dashboard.level-subjects.index');
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
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->levelSubjects->delete($request->id);
        toastr()->success(trans('message.success.delete'));
        return redirect()->route('dashboard.level-subjects.index');
    }
}

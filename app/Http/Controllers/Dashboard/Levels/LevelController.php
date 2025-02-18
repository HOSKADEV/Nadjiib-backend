<?php

namespace App\Http\Controllers\Dashboard\Levels;

use App\Models\Level;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Level\LevelRepository;
use App\Repositories\Section\SectionRepository;
use App\Repositories\Subject\SubjectRepository;

class LevelController extends Controller
{
    private $sections;
    private $levels;
    private $subjects;

    /**
     * LevelController constructor.
     * @param SectionRepository $sections
     * @param LevelRepository $levels
     * @param SubjectRepository $subjects
     */
    public function __construct(SectionRepository $sections , LevelRepository $levels, SubjectRepository $subjects)
    {
        $this->sections = $sections;
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
        $sections = $this->sections->all();
        $subjects = $this->subjects->table()->where('type','academic')->get();
        //$levels = $this->levels->paginate($perPage = 10, $request->search);
        $years = $this->levels->years($perPage = 10, $request->search, $request->section_id);
        return view('dashboard.level.index',compact('years','sections', 'subjects'));
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
        $this->levels->create($request->all());
        toastr()->success(trans('message.success.create'));
        return redirect()->route('dashboard.levels.index');
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
        $this->levels->update($request->id,$request->all());
        toastr()->success(trans('message.success.update'));
        return redirect()->route('dashboard.levels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->levels->delete($request->id);
        toastr()->success(trans('message.success.delete'));
        return redirect()->route('dashboard.levels.index');
    }
}

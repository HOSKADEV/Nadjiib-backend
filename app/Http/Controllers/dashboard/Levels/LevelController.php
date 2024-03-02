<?php

namespace App\Http\Controllers\Dashboard\Levels;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Level\LevelRepository;
use App\Repositories\Section\SectionRepository;

class LevelController extends Controller
{
    private $sections;
    private $levels;

    /**
     * LevelController constructor.
     * @param SectionRepository $sections
     * @param LevelRepository $levels
     */
    public function __construct(SectionRepository $sections , LevelRepository $levels)
    {
        $this->sections = $sections;
        $this->levels = $levels;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index(Request $request)
    {
        $sections = $this->sections->all();
        $levels = $this->levels->paginate($perPage = 10, $request->search);
        return view('dashboard.level.index',compact('levels','sections'));
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

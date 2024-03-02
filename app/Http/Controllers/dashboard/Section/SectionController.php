<?php

namespace App\Http\Controllers\Dashboard\Section;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Section\SectionRepository;

class SectionController extends Controller
{
    private $sections;

    /**
     * SectionController constructor.
     * @param SectionRepository $sections
     */
    public function __construct(SectionRepository $sections)
    {
        $this->sections = $sections;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sections = $this->sections->paginate($perPage = 10, $request->search);
        return view('dashboard.section.index',compact('sections'));
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
        $this->sections->create($request->all());
        toastr()->success(trans('message.success.create'));
        return redirect()->route('dashboard.sections.index');
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
        $this->sections->update($request->id,$request->all());
        toastr()->success(trans('message.success.update'));
        return redirect()->route('dashboard.sections.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->sections->delete($request->id);
        toastr()->success(trans('message.success.delete'));
        return redirect()->route('dashboard.sections.index');
    }
}

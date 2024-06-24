<?php

namespace App\Http\Controllers\Dashboard\Subject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Subject\SubjectRepository;

class SubjectController extends Controller
{
    private $subjects;

    /**
     * SubjectController constructor.
     * @param SubjectRepository $subjects
     */
    public function __construct(SubjectRepository $subjects)
    {
        $this->subjects = $subjects;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $subjects = $this->subjects->paginate($perPage = 10, $request->search);
        return view('dashboard.subject.index',compact('subjects'));
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
        $this->subjects->create($request->all());
        toastr()->success(trans('message.success.create'));
        return redirect()->route('dashboard.subjects.index');
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
        $this->subjects->update($request->id,$request->all());
        toastr()->success(trans('message.success.update'));
        return redirect()->route('dashboard.subjects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->subjects->delete($request->id);
        toastr()->success(trans('message.success.delete'));
        return redirect()->route('dashboard.subjects.index');
    }
}

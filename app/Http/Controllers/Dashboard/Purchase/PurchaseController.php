<?php

namespace App\Http\Controllers\Dashboard\Purchase;

use Exception;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index(Request $request)
  {
    // $purchases = Purchase::latest()->paginate(10);

     $purchases = Purchase::
     leftJoin('students', 'purchases.student_id', 'students.id')
     ->leftJoin('users', 'students.user_id', 'users.id')
     ->leftJoin('courses', 'purchases.course_id', 'courses.id')
     ->groupBy('student_id', 'course_id')
      ->select('student_id', 'course_id',
          DB::raw('users.name AS user_name'),
          DB::raw('courses.name AS course_name'),
          DB::raw('MAX(purchases.created_at) as created_at'))
      ->orderBy('created_at', 'DESC');


      if($request->search){
        $purchases = $purchases->where('users.name','like', '%'.  $request->search. '%')
        ->orWhere('courses.name', 'like', '%'.  $request->search. '%');
      }

      $purchases = $purchases->paginate(50);
    //dd($purchases);
    return view('dashboard.purchase.index', compact('purchases'));
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
    toastr()->success(trans('message.success.create'));
    return redirect()->route('dashboard.purchases.index');
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

    try{

      $purchase = Purchase::find($request->id);

      if($purchase->student->owns($purchase->course)){
        throw new Exception(trans('message.prohibited'));
      }

      $purchase->status = $request->status;
      $purchase->reject_reason = $request->reject_reason;
      $purchase->save();

      if ($request->status == 'success') {

        $purchase->apply_subscription();

      }

      $purchase->refresh();
      $purchase->notify();

      toastr()->success(trans('message.success.update'));
      return redirect()->route('dashboard.purchases.index');

    }catch(Exception $e){
      toastr()->error($e->getMessage());
      return redirect()->route('dashboard.purchases.index');
    }

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    toastr()->success(trans('message.success.delete'));
    return redirect()->route('dashboard.purchases.index');
  }
}

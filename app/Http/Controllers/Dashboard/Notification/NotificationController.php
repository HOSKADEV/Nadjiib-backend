<?php

namespace App\Http\Controllers\Dashboard\Notification;

use App\Models\User;
use App\Models\Notice;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
  public function index(Request $request)
  {
    $notices = Notice::where('type', 6);

    if ($request->search) {
      $notices->where(function ($query) use ($request) {
        $query->where('title_ar', "like", "%{$request->search}%");
        $query->orWhere('title_en', 'like', "%{$request->search}%");
        $query->orWhere('title_fr', 'like', "%{$request->search}%");
        $query->orWhere('content_ar', "like", "%{$request->search}%");
        $query->orWhere('content_en', 'like', "%{$request->search}%");
        $query->orWhere('content_fr', 'like', "%{$request->search}%");
      });
    }

    $notices = $notices->paginate(10);
    return view('dashboard.notice.index', compact('notices'));
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
    $notice = Notice::create($request->all());
    toastr()->success(trans('message.success.create'));
    return redirect()->route('dashboard.notices.index');
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
    $notice = Notice::findOrFail($request->id);
    $notice->update($request->all());
    toastr()->success(trans('message.success.update'));
    return redirect()->route('dashboard.notices.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $notice = Notice::findOrFail($request->id);
    $notice->notifications()->delete();
    $notice->delete();
    toastr()->success(trans('message.success.delete'));
    return redirect()->route('dashboard.notices.index');
  }

  public function broadcast(Request $request)
  {


    $users = User::where('status', 'ACTIVE');

    if (intval($request->broadcast_to)) {
      $users = $users->where('role', $request->broadcast_to);
    } else {
      $users = $users->whereNot('role', 0);
    }

    $data = $users->get('id')->toArray();

    array_walk($data, function (&$item, $key) use ($request) {
      $item = [
        'user_id' => $item['id'],
        'notice_id' => $request->notice_id,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ];
    });


    Notification::insert($data);

    if (intval($request->broadcast_type)) {
      $notice = Notice::find($request->notice_id);
      $users = $users->whereNot('fcm_token', null);

      if ($notice && $users->count()) {
        $this->send_fcm_multi(
          $notice->title(Session::get('locale')),
          $notice->content(Session::get('locale')),
          $users->pluck('fcm_token')->toArray()
        );
      }
    }

    toastr()->success(trans('message.success.create'));
    return redirect()->route('dashboard.notices.index');

  }
}

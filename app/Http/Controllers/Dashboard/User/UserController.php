<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Models\User;
use App\Enums\CouponType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Teacher\TeacherRepository;
use App\Http\Requests\User\UpgradeAccountRequest;

class UserController extends Controller
{
  private $users;
  private $teachers;
  private $coupons;

  /**
   * UserController constructor.
   * @param UserRepository $users
   * @param TeacherRepository $teachers
   * @param CouponRepository $coupons
   */
  public function __construct(UserRepository $users, TeacherRepository $teachers, CouponRepository $coupons)
  {
    $this->users = $users;
    $this->teachers = $teachers;
    $this->coupons = $coupons;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $users = $this->users->paginate($perPage = 10, $request->search, $request->status, $request->role);

    return view('dashboard.user.index', compact('users'));
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
    $user = $this->users->find($id);
    return view('dashboard.user.edit', compact('user'));
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
    $this->users->update($request->id, $request->all());
    toastr()->success(trans('message.success.update'));
    return redirect()->route('dashboard.users.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $user = User::find($request->id);

    $user->update(['status' => 'DELETED', 'email' => 'deleted_user#' . $user->id . '@mail.com', 'fcm_token' => null]);

    $user->tokens()->delete();

    if ($user->teacher) {
      $user->teacher->courses()->delete();
    }

    toastr()->success(trans('message.success.delete'));
    return redirect()->route('dashboard.users.index');
  }

  /**
   * Update Account Status.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function changeStatus(Request $request)
  {
    $this->users->changeStatus($request->id);
    toastr()->success(trans('message.success.update'));
    return redirect()->route('dashboard.users.index');
  }

  /**
   * Upgrade Account .
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function upgradeAccount(UpgradeAccountRequest $request)
  {
    // $this->coupons->create();
    $data = [
      'type' => CouponType::INVITATION,
      'code' => Str::upper(Str::random(8))
    ];
    $coupon = $this->coupons->create($data);

    $this->teachers->create([
      'user_id' => $request->id,
      'coupon_id' => $coupon->id
    ]);
    toastr()->success(trans('message.success.upgrade'));
    return redirect()->route('dashboard.users.index');
  }
}

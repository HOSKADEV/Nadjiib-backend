<?php

namespace App\Http\Controllers\Dashboard\Ad;

use App\Models\Ad;
use App\Models\CourseAd;
use App\Models\TeacherAd;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\uploadFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdController extends Controller
{

  use uploadFile;
  public function index(Request $request)
  {
    $ads = Ad::orderBy("created_at", "desc");
    if ($request->search) {
      $ads = $ads->where('name', 'LIKE', '%' . $request->search . '%');
    }
    if ($request->type) {
      $ads = $ads->where('type', $request->type);
    }
    $ads = $ads->paginate(10);
    return view('dashboard.ad.index', compact('ads'));
  }

  public function destroy(Request $request)
  {
    $ad = Ad::find($request->id);
    $ad->delete();
    toastr()->success(trans('message.success.delete'));
    return redirect()->back();
  }

  public function store(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'name' => ['required', 'string'],
      'type' => ['required', 'in:url,course,teacher'],
      'url' => ['required_if:type,url', 'string'],
      'image' => ['required'],
      'course_id' => ['required_if:type,course', 'exists:courses,id'],
      'teacher_id' => ['required_if:type,teacher', 'exists:teachers,id'],
    ]);

    if ($validation->fails()) {
      toastr()->error(trans($validation->messages()->first()));
    } else {
      $pathImage = $this->SaveImage($request->image, 'images/ads/image/');
      $ad = Ad::create($request->only('name','type', 'url'));
      $ad->image = $pathImage->getPathName();
      $ad->save();

      $request->merge(['ad_id' => $ad->id]);

      if($request->has('course_id')){
        CourseAd::create($request->only('course_id', 'ad_id'));
      }
      if($request->has('teacher_id')){
        TeacherAd::create($request->only('teacher_id', 'ad_id'));
      }
      toastr()->success(trans('message.success.create'));
    }


    return new Response('', 200, ['HX-Redirect' => url()->previous()]);
  }


  public function update(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'id' => ['required', 'exists:ads'],
      'name' => ['sometimes', 'string'],
      'type' => ['required', 'in:url,course,teacher'],
      'url' => ['required_if:type,url', 'string'],
      'image' => ['sometimes']
    ]);

    if ($validation->fails()) {
      toastr()->error(trans($validation->messages()->first()));
    } else {
      $ad = Ad::find($request->id);
      $ad->update($request->except('image', 'id'));
      if ($request->image) {
        $pathImage = $this->SaveImage($request->image, 'images/ads/image/');
        $ad->image = $pathImage->getPathName();
        $ad->save();
      }

      toastr()->success(trans('message.success.create'));
    }


    return new Response('', 200, ['HX-Redirect' => route('dashboard.ads.index')]);
  }
}

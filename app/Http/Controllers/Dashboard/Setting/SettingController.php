<?php

namespace App\Http\Controllers\Dashboard\Setting;

use Exception;
use App\Models\Setting;
use App\Models\Version;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use App\Models\Documentation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
  public function index(){
    $android = Version::android();
    $ios = Version::ios();

    $posts_number = Setting::where('name','posts_number')->value('value');
    $cloud_bonus = Setting::where('name','cloud_bonus')->value('value');
    $standard_bonus = Setting::where('name','standard_bonus')->value('value');
    $community_bonus = Setting::where('name','community_bonus')->value('value');
    $invitation_bonus = Setting::where('name','invitation_bonus')->value('value');
    $invitation_discount = Setting::where('name','invitation_discount')->value('value');
    $email = Setting::where('name','email')->value('value');
    $whatsapp = Setting::where('name','whatsapp')->value('value');
    $facebook = Setting::where('name','facebook')->value('value');
    $instagram = Setting::where('name','instagram')->value('value');
    $ccp = Setting::where('name','ccp')->value('value');
    $baridi_mob = Setting::where('name','baridi_mob')->value('value');
    $form_image = Setting::where('name','form_image')->value('value');
    $calls_duration = Setting::where('name','calls_duration')->value('value');

    $calls_duration = CarbonInterval::seconds($calls_duration)->cascade();
    $form_image = $form_image ? url($form_image) : null;

    $duration_hours = $calls_duration->h;
    $duration_minutes = $calls_duration->i;
    $duration_seconds = $calls_duration->s;

    return view('dashboard.settings.index')
    ->with('android',$android)
    ->with('ios',$ios)
    ->with('posts_number',$posts_number)
    ->with('cloud_bonus',$cloud_bonus)
    ->with('standard_bonus',$standard_bonus)
    ->with('community_bonus',$community_bonus)
    ->with('invitation_bonus',$invitation_bonus)
    ->with('invitation_discount',$invitation_discount)
    ->with('email',$email)
    ->with('facebook',$facebook)
    ->with('instagram',$instagram)
    ->with('whatsapp',$whatsapp)
    ->with('ccp',$ccp)
    ->with('baridi_mob',$baridi_mob)
    ->with('duration_hours',$duration_hours)
    ->with('duration_minutes',$duration_minutes)
    ->with('duration_seconds',$duration_seconds)
    ->with('form_image', $form_image)
    ;


  }

  public function version(Request $request){
    $validator = Validator::make($request->all(), [
      'android_version_number' => 'required',
      'android_build_number' => 'required',
      'android_priority' => 'required',
      'android_link' => 'required',
      'ios_version_number' => 'required',
      'ios_build_number' => 'required',
      'ios_priority' => 'required',
      'ios_link' => 'required',
    ]);



    if ($validator->fails()) {
      return response()->json([
        'status'=> 0,
        'message' => $validator->errors()->first()
      ]);
    }

    $android = Version::android();
    $ios = Version::ios();

    $android->version_number = $request->android_version_number;
    $android->build_number = $request->android_build_number;
    $android->priority = $request->android_priority;
    $android->link = $request->android_link;

    $ios->version_number = $request->ios_version_number;
    $ios->build_number = $request->ios_build_number;
    $ios->priority = $request->ios_priority;
    $ios->link = $request->ios_link;

    $android->save();
    $ios->save();


    return response()->json([
      'status'=> 1,
      'message' => 'success'
    ]);

  }

  public function misc(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'calls_duration' => 'sometimes|numeric',
      'posts_number' => 'sometimes|numeric',
      'cloud_bonus' => 'sometimes|numeric',
      'community_bonus' => 'sometimes|numeric',
      'invitation_bonus' => 'sometimes|numeric',
      'invitation_discount' => 'sometimes|numeric',
      'standard_bonus' => 'sometimes|numeric',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 0,
        'message' => $validator->errors()->first()
      ]);
    }

    try {

      foreach ($request->keys() as $key) {
        Setting::updateOrInsert(['name' => $key], ['value' => $request[$key]]);
      }

      return response()->json([
        'status' => 1,
        'message' => 'success'
      ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => 0,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function contact(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'sometimes|email|string',
      'whatsapp' => 'sometimes|string',
      'facebook' => 'sometimes|string',
      'instagram' => 'sometimes|string',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 0,
        'message' => $validator->errors()->first()
      ]);
    }

    try {

      foreach ($request->keys() as $key) {
        Setting::updateOrInsert(['name' => $key], ['value' => $request[$key]]);
      }

      return response()->json([
        'status' => 1,
        'message' => 'success'
      ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => 0,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function bank(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'ccp' => 'sometimes|string',
      'baridi_mob' => 'sometimes|string',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 0,
        'message' => $validator->errors()->first()
      ]);
    }

    try {

      if($request->hasFile('image')){
        $form_image = $request->image->store('images', 'upload');
        $request->merge(['form_image' => $form_image]);
      }

      foreach (array_keys($request->except('image')) as $key) {
        Setting::updateOrInsert(['name' => $key], ['value' => $request[$key]]);
      }

      return response()->json([
        'status' => 1,
        'message' => 'success'
      ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => 0,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function doc_index(Request $request){
    if($request->route()->getName() == 'dashboard.documentation.policy'){
      return view('dashboard.documentation.index')->with('documentation',Documentation::privacy_policy());
    }elseif($request->route()->getName() == 'dashboard.documentation.about'){
      return view('dashboard.documentation.index')->with('documentation',Documentation::about());
    }else{
      return redirect()->back();
    }

  }

  public function documentation(Request $request){

    //dd($request->all());

    $validator = Validator::make($request->all(), [
      'name' => 'required|string',
      'content_ar' => 'sometimes|string',
      'content_en' => 'sometimes|string',
    ]);

    if ($validator->fails()){
      return response()->json([
          'status' => 0,
          'message' => $validator->errors()->first()
        ]
      );
    }

    try{

      Documentation::updateOrInsert(
        ['name' => $request->name],
        $request->all()
      );

      return response()->json([
        'status' => 1,
        'message' => 'success',
      ]);

    }catch(Exception $e){
      return response()->json([
        'status' => 0,
        'message' => $e->getMessage()
      ]
    );
    }

  }
}

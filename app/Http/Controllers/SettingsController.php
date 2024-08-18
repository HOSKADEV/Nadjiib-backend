<?php

namespace App\Http\Controllers;

use App\Models\PurchaseBonus;
use Exception;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Documentation;
use App\Models\PurchaseCoupon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
  public function info()
  {
    try {

      $email = Setting::where('name', 'email')->value('value');
      $whatsapp = Setting::where('name', 'whatsapp')->value('value');
      $facebook = Setting::where('name', 'facebook')->value('value');
      $instagram = Setting::where('name', 'instagram')->value('value');
      $ccp = Setting::where('name', 'ccp')->value('value');
      $baridi_mob = Setting::where('name', 'baridi_mob')->value('value');

      $data = [
        'ccp' => $ccp,
        'baridi_mob' => $baridi_mob,
        'email' => $email,
        'whatsapp' => $whatsapp,
        'facebook' => $facebook,
        'instagram' => $instagram,
      ];

      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => $data
      ]);

    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }
  public function progress(Request $request)
  {
    try {

      $user = $request->user();

      $teacher = $user?->teacher;

      if(empty($teacher)){
        throw new Exception('no teacher found');
      }

      $posts_number = Setting::where('name','posts_number')->value('value');
      $calls_duration = Setting::where('name','calls_duration')->value('value');

      $posts_number = empty($posts_number) ? 0 : intval($posts_number);
      $calls_duration = empty($calls_duration) ? 0 : intval($calls_duration);

      $teacher_posts = $teacher->posts()->where(DB::raw('DATE(created_at)'), '>=', Carbon::now()->startOfMonth())
      ->where(DB::raw('DATE(created_at)'), '<=', Carbon::now()->endOfMonth())->count();

      $teacher_calls = $teacher->calls()->where(DB::raw('DATE(created_at)'), '>=', Carbon::now()->startOfMonth())
      ->where(DB::raw('DATE(created_at)'), '<=', Carbon::now()->endOfMonth())->sum('duration');

      $teacher_purchases = $teacher->purchases()->where(DB::raw('DATE(purchases.created_at)'), '>=', Carbon::now()->startOfMonth())
      ->where(DB::raw('DATE(purchases.created_at)'), '<=', Carbon::now()->endOfMonth())->where('purchases.status','success');

      $teacher_total_amount = $teacher_purchases->sum('purchases.price');

      $teacher_bonuses_amount = PurchaseBonus::whereIn('purchase_id',$teacher_purchases->pluck('purchases.id')->toArray())->whereIn('type',[2,3])->sum('amount');

      $teacher_bonuses_percentage = $teacher_bonuses_amount / $teacher_total_amount;

      $cloud_percentage = min(1, $teacher_calls / $calls_duration);

      $community_percentage = min(1, $teacher_posts / $posts_number);

      $data = [
        'cloud' => [
          'progress' => intval($teacher_calls),
          'threshold' => $calls_duration,
          'percentage' => $cloud_percentage,
        ],
        'community' => [
          'progress' => $teacher_posts,
          'threshold' => $posts_number,
          'percentage' => $community_percentage,
        ],
        'total' => [
          'progress' => ($community_percentage + $cloud_percentage ) / 2,
          'amount' => $teacher_bonuses_amount,
          'percentage' => $teacher_bonuses_percentage,
        ],
      ];

      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => $data
      ]);

    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }


  public function stats(Request $request)
  {
    try {

      $user = $request->user();
      $teacher = $user?->teacher;

      if (empty($teacher)) {
        throw new Exception('no teacher found');
      }
      $total_purchases = $teacher->purchases()->where('purchases.status', 'success')->count();
      $invited_purchases = PurchaseCoupon::whereIn(
        'purchase_id',
        $teacher->purchases()->where('purchases.status', 'success')->select('purchases.id')->get()->pluck('id')->toArray()
      )
        ->where('coupon_id', $teacher->coupon_id)->count();
      $normal_purchases = $total_purchases - $invited_purchases;

      $data = [
        'total_purchases' => $total_purchases,
        'invited_purchases' => $invited_purchases,
        'normal_purchases' => $normal_purchases,
      ];

      return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => $data
      ]);

    } catch (Exception $e) {
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function policy(Request $request)
  {
    try {

      $lang = $request->header('Accept-language', 'ar');
      $privacy_policy = Documentation::privacy_policy();

      return response()->json([
        'status' => 1,
        'message' => 'success',
        'data' => ['content' => $privacy_policy->content($lang)]
      ]);

    } catch (Exception $e) {
      return response()->json(
        [
          'status' => 0,
          'message' => $e->getMessage()
        ]
      );
    }
  }

  public function about(Request $request)
  {
    try {

      $lang = $request->header('Accept-language', 'ar');
      $about = Documentation::about();

      return response()->json([
        'status' => 1,
        'message' => 'success',
        'data' => ['content' => $about->content($lang)]
      ]);

    } catch (Exception $e) {
      return response()->json(
        [
          'status' => 0,
          'message' => $e->getMessage()
        ]
      );
    }
  }

}

<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\PurchaseCoupon;

class SettingsController extends Controller
{
  public function info(){
    try {

      $data = [
        'ccp' => 'XXXXXXXXXXXXXXXXX',
        'baridi_mob' => 'XXXXXXXXXXXXXXXXX',
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
  }public function progress(){
    try {

      $data = [
        'cloud' => [
          'progress' => 50,
          'threshold' => 100,
          'percentage' => 0.5,
        ],
        'community' => [
          'progress' => 10,
          'threshold' => 30,
          'percentage' => 0.3,
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


public function stats(Request $request){
  try {

    $user = $request->user();
    $teacher = $user?->teacher;

    if(empty($teacher)){
      throw new Exception('no teacher found');
    }
    $total_purchases = $teacher->purchases()->where('purchases.status', 'success')->count();
    $invited_purchases = PurchaseCoupon::whereIn('purchase_id',
    $teacher->purchases()->where('purchases.status', 'success')->select('purchases.id')->get()->pluck('id')->toArray())
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

}

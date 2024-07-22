<?php

namespace App\Http\Controllers\API\Coupons;

use Exception;
use App\Models\Coupon;
use App\Rules\ValidCoupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Coupon\CouponRepository;
use App\Http\Resources\Coupons\PaginateCouponCollection;

class CouponController extends Controller
{
    private $coupon;

    public function __construct(CouponRepository $coupon){
      $this->coupon = $coupon;
    }

    public function getCoupon(){
      try
      {
          $coupon = $this->coupon->paginate(10);
          return response()->json([
            'status' => true,
            'coupon' => new PaginateCouponCollection($coupon)
          ]);
      }
      catch(Exception $e)
      {
        return response()->json([
          'status'  => false,
          'message' => $e->getMessage()
        ]);
      }
    }


    public function validateCoupon(Request $request){
      $validation = Validator::make($request->all(), [
        'course_id' => 'required_with:invitation_code|exists:courses,id',
        'coupon_code' => ['exists:coupons,code', new ValidCoupon($request)],
        'invitation_code' => ['exists:coupons,code', new ValidCoupon($request)],
      ]);

      if ($validation->fails()) {
        return response()->json([
          'status' => false,
          'message' => $validation->errors()->first(),
          //'message' => 'Invalid coupon',
          //'errors' => $validation->errors()
        ]);
      }else{
        return response()->json([
          'status' => true,
          'message' => 'Valid coupon'
        ]);
      }
    }
}

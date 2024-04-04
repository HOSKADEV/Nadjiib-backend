<?php

namespace App\Http\Controllers\API\Coupons;

use App\Http\Controllers\Controller;
use App\Http\Resources\Coupons\PaginateCouponCollection;
use App\Repositories\Coupon\CouponRepository;
use Illuminate\Http\Request;
use Exception;
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
}

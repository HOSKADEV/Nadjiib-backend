<?php

namespace App\Http\Controllers\Dashboard\Coupon;

use App\Enums\CouponType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Coupon\CouponRepository;
use App\Http\Requests\Coupon\StoreCouponRequest;
use App\Http\Requests\Coupon\UpdateCouponRequest;

class CouponController extends Controller
{
    private $coupons;

    /**
     * CouponController constructor.
     * @param CouponRepository $coupons
     */
    public function __construct(CouponRepository $coupons)
    {
        $this->coupons = $coupons;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $coupons = $this->coupons->paginate($perPage = 10, $request->search);
        return view('dashboard.coupon.index',compact('coupons'));
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
    public function store(StoreCouponRequest $request)
    {
        $validated = $request->validated();
        $data = array_replace($request->all() ,[
            'type' => CouponType::LIMITED
        ]);
        $this->coupons->create($request->all());
        toastr()->success(trans('message.success.create'));
        return redirect()->route('dashboard.coupons.index');
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
    public function update(UpdateCouponRequest $request)
    {
        $validated = $request->validated();
        $this->coupons->update($request->id,$request->all());
        toastr()->success(trans('message.success.update'));
        return redirect()->route('dashboard.coupons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->coupons->delete($request->id);
        toastr()->success(trans('message.success.delete'));
        return redirect()->route('dashboard.coupons.index');
    }
}

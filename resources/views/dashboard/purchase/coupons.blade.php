<div class="modal fade" id="usedCouponsModal{{ $purchase->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('purchase.coupons') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                  <table class="table">
                    <thead>
                        <tr>
                            <th>{{trans('purchase.coupon.code')}}</th>
                            <th>{{trans('purchase.coupon.percentage')}}</th>
                            <th>{{trans('purchase.coupon.amount')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($purchase->used_coupons as $used_coupon)
                      <tr>
                        <td>{{$used_coupon->coupon->code}}</td>
                        <td>{{$used_coupon->percentage}}%</td>
                        <td>{{$used_coupon->amount}} {{trans('app.currencies.DZ')}}</td>
                    </tr>
                      @endforeach

                        <tr class="table-primary fw-bold">
                            <td>{{trans('app.total')}}</td>
                            <td>{{$purchase->used_coupons()->sum('percentage')}}%</td>
                            <td>{{$purchase->used_coupons()->sum('amount')}} {{trans('app.currencies.DZ')}}</td>
                        </tr>
                    </tbody>
                </table>

                </div>
                {{-- <div class="modal-footer">

                </div> --}}
            </div>
    </div>
</div>

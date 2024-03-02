<div class="modal fade" id="createCouponModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <form action="{{ route('dashboard.coupons.store') }}" method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('coupon.create') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="code" class="form-label">{{ trans('coupon.label.code') }}</label>
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" id="code" name="code" class="form-control mx-2" placeholder="{{ trans('coupon.placeholder.code') }}">
                                </div>
                                <div class="col-2 pt-2 btn pl-1">
                                    <img id="generate" src="{{ asset('assets/img/icons/captcha.png') }}" width="20px" alt="" srcset="">
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="discount" class="form-label">{{ trans('coupon.label.discount') }}</label>
                            <input type="text" id="discount" name="discount" class="form-control" placeholder="{{ trans('coupon.placeholder.discount') }}">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="start_date" class="form-label">{{ trans('coupon.label.start_date') }}</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" placeholder="{{ trans('section.placeholder.name_fr') }}">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="end_date" class="form-label">{{ trans('coupon.label.end_date') }}</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" placeholder="{{ trans('section.placeholder.name_fr') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ trans('app.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('app.create') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
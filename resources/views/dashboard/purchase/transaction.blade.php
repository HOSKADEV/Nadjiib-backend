<div class="modal fade" id="transactionModal{{ $purchase->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('purchase.info') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label"
                                        for="android_version_number">{{ trans('purchase.price') }}</label>
                                    <input type="text" class="form-control" value="{{ $purchase->price }}"
                                        disabled />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="android_build_number">{{ trans('purchase.discount') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ $purchase->used_coupons()->sum('amount') }}" disabled />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="android_priority">{{ trans('purchase.total') }}</label>
                                    <input type="text" class="form-control" value="{{ $purchase->total }}"
                                        disabled />
                                </div>

                                <div class="mb-3">
                                  <label class="form-label"
                                      for="android_priority">{{ trans('purchase.payment_method') }}</label>
                                  <input type="text" class="form-control" value="{{ $purchase->payment_method }}"
                                      disabled />
                              </div>

                              <div class="mb-3">
                                <label class="form-label"
                                    for="android_priority">{{ trans('purchase.account') }}</label>
                                <input type="text" class="form-control" value="{{ $purchase->transaction?->account }}"
                                    disabled />
                            </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl">
                        <div class="card mb-4">
                            <div class="card-body">

                                <embed class="pdf"
                                    src="{{$purchase->receipt()}}{{-- https://media.geeksforgeeks.org/wp-content/cdn-uploads/20210101201653/PDF.pdf --}}"
                                    width="100%" height="500">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--  <div class="modal-footer">
              </div> --}}
        </div>
        </form>
    </div>
</div>

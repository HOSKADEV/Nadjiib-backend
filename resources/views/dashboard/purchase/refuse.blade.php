<div class="modal fade" id="refusePurchaseModal{{ $purchase->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('dashboard.purchases.update', 'test') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="id" name="id" class="form-control" value="{{ $purchase->id }}">
            <input type="hidden" id="status" name="status" class="form-control" value="failed">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('purchase.refuse') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ trans('purchase.refuse_confirmation') }}</p>

                    <div class="mb-3">
                      <label class="form-label" for="reject_reason">{{ trans('purchase.reject_reason') }}</label>
                      <textarea  class="form-control" name="reject_reason" rows="3" placeholder="{{ trans('purchase.reject_placeholder') }}"></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">{{ trans('app.close') }}</button>
                    <button type="submit" class="btn btn-danger">{{ trans('app.ok') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

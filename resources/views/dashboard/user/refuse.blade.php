<div class="modal fade" id="refusePurchaseModal{{ $tr->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <form action="{{ route('dashboard.wallet.update', 'test') }}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" id="id" name="id" class="form-control" value="{{ $tr->id }}">
          <input type="hidden" id="status" name="status" class="form-control" value="{{App\Enums\WalletTransactionStatus::FAILED}}">

          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel1">{{ trans('purchase.refuse') }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

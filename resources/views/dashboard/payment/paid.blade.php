<div class="modal fade" id="paidModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('dashboard.payments.update', 'test') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="id" name="id" class="form-control" value="{{ $payment->id }}">
            <input type="hidden" id="is_paid" name="is_paid" class="form-control" value="yes">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('payment.paid') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ trans('payment.paid_confirmation') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">{{ trans('app.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('app.ok') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

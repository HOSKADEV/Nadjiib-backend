<div class="modal fade" id="infoModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('teacher.info') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ trans('user.label.name') }}</label>
                            <input type="text" class="form-control"
                                value="{{ $payment->teacher?->user?->name }}" disabled />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ trans('user.label.phone') }}</label>
                            <input type="text" class="form-control"
                                value="{{ $payment->teacher?->user?->phone }}" disabled />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ trans('user.label.email') }}</label>
                            <input type="text" class="form-control"
                                value="{{ $payment->teacher?->user?->email }}" disabled />
                        </div>
                        <div class="mb-3">
                          <label class="form-label">{{ trans('user.label.ccp') }}</label>
                          <input type="text" class="form-control"
                              value="{{ $payment->teacher?->user?->ccp }}" disabled />
                      </div>
                      <div class="mb-3">
                        <label class="form-label">{{ trans('user.label.baridi_mob') }}</label>
                        <input type="text" class="form-control"
                            value="{{ $payment->teacher?->user?->baridi_mob }}" disabled />
                    </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

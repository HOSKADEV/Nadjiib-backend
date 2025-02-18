<div class="modal fade" id="infoModal{{ $purchase->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel1">{{ trans('purchase.info') }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-xl">
                      <div class="card mb-4">
                          <div class="card-header d-flex justify-content-between align-items-center">
                              <h5 class="mb-0">{{ trans('purchase.student') }}</h5>
                              <small class="text-muted float-end">{{ trans('purchase.student_info') }}</small>
                          </div>
                          <div class="card-body">
                              <div class="mb-3">
                                  <label class="form-label" for="android_version_number">{{ trans('user.label.name') }}</label>
                                  <input type="text" class="form-control" value="{{ $purchase->student?->user?->name }}" disabled/>
                              </div>

                              <div class="mb-3">
                                  <label class="form-label" for="android_build_number">{{ trans('user.label.phone') }}</label>
                                  <input type="text" class="form-control" value="{{ $purchase->student?->user?->phone }}" disabled/>
                              </div>

                              <div class="mb-3">
                                  <label class="form-label" for="android_priority">{{ trans('user.label.email') }}</label>
                                  <input type="text" class="form-control" value="{{ $purchase->student?->user?->email }}" disabled/>
                              </div>
                          </div>
                      </div>
                  </div>


                  <div class="col-xl">
                      <div class="card mb-4">
                          <div class="card-header d-flex justify-content-between align-items-center">
                              <h5 class="mb-0">{{ trans('purchase.teacher') }}</h5>
                              <small class="text-muted float-end">{{ trans('purchase.teacher_info') }}</small>
                          </div>
                          <div class="card-body">
                            <div class="mb-3">
                              <label class="form-label" for="android_version_number">{{ trans('user.label.name') }}</label>
                              <input type="text" class="form-control" value="{{ $purchase->course?->teacher?->user?->name }}" disabled/>
                          </div>

                          <div class="mb-3">
                              <label class="form-label" for="android_build_number">{{ trans('user.label.phone') }}</label>
                              <input type="text" class="form-control" value="{{ $purchase->course?->teacher?->user?->phone }}" disabled/>
                          </div>

                          <div class="mb-3">
                              <label class="form-label" for="android_priority">{{ trans('user.label.email') }}</label>
                              <input type="text" class="form-control" value="{{ $purchase->course?->teacher?->user?->email }}" disabled/>
                          </div>
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

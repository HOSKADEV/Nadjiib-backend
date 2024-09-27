<div class="modal fade" id="broadcastNoticeModal{{$notice->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('dashboard.notices.broadcast') }}" method="POST">
            @csrf
            @method('POST')
            <input type="hidden" name="notice_id" value="{{$notice->id}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('notice.broadcast.broadcast') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="broadcast_to" class="form-label">{{ trans('notice.label.broadcast_to') }}</label>
                            <select class="form-select" name="broadcast_to" >
                              <option value="0">{{trans('notice.broadcast.all_users')}}</option>
                              <option value="1">{{trans('notice.broadcast.students_only')}}</option>
                              <option value="2">{{trans('notice.broadcast.teachers_only')}}</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                          <label for="broadcast_type" class="form-label">{{ trans('notice.label.broadcast_type') }}</label>
                          <select class="form-select" name="broadcast_type" >
                            <option value="0">{{trans('notice.broadcast.silent')}}</option>
                            <option value="1">{{trans('notice.broadcast.vocal')}}</option>
                          </select>
                      </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">{{ trans('app.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('app.send') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editNoticeModal{{ $notice->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('dashboard.notices.update','test') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="id" name="id" class="form-control" value="{{ $notice->id }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('notice.edit') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="title_ar" class="form-label">{{ trans('notice.label.title_ar') }}</label>
                            <input type="text" id="title_ar" name="title_ar" class="form-control" value="{{ $notice->title_ar }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="title_en" class="form-label">{{ trans('notice.label.title_en') }}</label>
                            <input type="text" id="title_en" name="title_en" class="form-control" value="{{ $notice->title_en }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="title_fr" class="form-label">{{ trans('notice.label.title_fr') }}</label>
                            <input type="text" id="title_fr" name="title_fr" class="form-control" value="{{ $notice->title_fr }}">
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-12 mb-3">
                          <label for="content_ar" class="form-label">{{ trans('notice.label.content_ar') }}</label>
                          <textarea id="content_ar" name="content_ar" class="form-control">{{$notice->content_ar}}</textarea>
                      </div>
                      <div class="col-12 mb-3">
                        <label for="content_en" class="form-label">{{ trans('notice.label.content_en') }}</label>
                        <textarea id="content_en" name="content_en" class="form-control">{{$notice->content_en}}</textarea>
                    </div>
                      <div class="col-12 mb-3">
                          <label for="content_fr" class="form-label">{{ trans('notice.label.content_fr') }}</label>
                          <textarea id="content_fr" name="content_fr" class="form-control">{{$notice->content_fr}}</textarea>
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ trans('app.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('app.update') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

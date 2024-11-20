<div class="modal fade" id="createNoticeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('dashboard.notices.store') }}" method="POST">
            @csrf
            @method('POST')
            <input type="hidden" name="type" value="6">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('notice.create') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="title_ar" class="form-label">{{ trans('notice.label.title_ar') }}</label>
                            <input type="text" id="title_ar" name="title_ar" class="form-control"
                                placeholder="{{ trans('notice.placeholder.title_ar') }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="title_en" class="form-label">{{ trans('notice.label.title_en') }}</label>
                            <input type="text" id="title_en" name="title_en" class="form-control"
                                placeholder="{{ trans('notice.placeholder.title_en') }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="title_fr" class="form-label">{{ trans('notice.label.title_fr') }}</label>
                            <input type="text" id="title_fr" name="title_fr" class="form-control"
                                placeholder="{{ trans('notice.placeholder.title_fr') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="content_ar" class="form-label">{{ trans('notice.label.content_ar') }}</label>
                            <textarea id="content_ar" name="content_ar" class="form-control"
                                placeholder="{{ trans('notice.placeholder.content_ar') }}"></textarea>
                        </div>
                        <div class="col-12 mb-3">
                          <label for="content_en" class="form-label">{{ trans('notice.label.content_en') }}</label>
                          <textarea id="content_en" name="content_en" class="form-control"
                              placeholder="{{ trans('notice.placeholder.content_en') }}"></textarea>
                      </div>
                        <div class="col-12 mb-3">
                            <label for="content_fr" class="form-label">{{ trans('notice.label.content_fr') }}</label>
                            <textarea id="content_fr" name="content_fr" class="form-control"
                                placeholder="{{ trans('notice.placeholder.content_fr') }}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">{{ trans('app.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('app.create') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

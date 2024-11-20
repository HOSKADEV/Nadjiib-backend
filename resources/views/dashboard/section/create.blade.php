<div class="modal fade" id="createSectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('dashboard.sections.store') }}" method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('section.create') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="name_ar" class="form-label">{{ trans('section.label.name_ar') }}</label>
                            <input type="text" id="name_ar" name="name_ar" class="form-control" placeholder="{{ trans('section.placeholder.name_ar') }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="name_en" class="form-label">{{ trans('section.label.name_en') }}</label>
                            <input type="text" id="name_en" name="name_en" class="form-control" placeholder="{{ trans('section.placeholder.name_en') }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="name_fr" class="form-label">{{ trans('section.label.name_fr') }}</label>
                            <input type="text" id="name_fr" name="name_fr" class="form-control" placeholder="{{ trans('section.placeholder.name_fr') }}">
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
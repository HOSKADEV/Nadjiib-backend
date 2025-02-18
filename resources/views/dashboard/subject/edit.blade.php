<div class="modal fade" id="editSubjectModal{{ $subject->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('dashboard.subjects.update','test') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="id" name="id" class="form-control" value="{{ $subject->id }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('subject.edit') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="name_ar" class="form-label">{{ trans('subject.label.name_ar') }}</label>
                            <input type="text" id="name_ar" name="name_ar" class="form-control" value="{{ $subject->name_ar }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="name_en" class="form-label">{{ trans('subject.label.name_en') }}</label>
                            <input type="text" id="name_en" name="name_en" class="form-control" value="{{ $subject->name_en }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="name_fr" class="form-label">{{ trans('subject.label.name_fr') }}</label>
                            <input type="text" id="name_fr" name="name_fr" class="form-control" value="{{ $subject->name_fr }}">
                        </div>
                        <div class="col-12 mb-3">
                          <label for="type" class="form-label">{{ trans('subject.label.type') }}</label>
                          <select id="type" name="type" class="form-select">
                              <option value="academic" {{$subject->type == 'academic' ? 'selected' : ''}}> {{ trans('subject.academic') }} </option>
                              <option value="extracurricular" {{$subject->type == 'extracurricular' ? 'selected' : ''}}> {{ trans('subject.extracurricular') }} </option>
                          </select>
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

<div class="modal fade" id="createLevelSubjectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('level.create') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.level-subjects.store') }}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="repeater" id="repeater">
                        <div data-repeater-list="list_level_subjects">
                            <div data-repeater-item class="row mb-3">
                                <div class="col-5">
                                    <label for="level" class="form-label">{{ trans('levelsubject.label.level') }}</label>
                                    <select class="form-select" id="level" name="level">
                                        <option selected disabled>{{ trans('levelsubject.select.level') }}</option>
                                        @foreach ($levels as $key => $level)
                                            <option value="{{ $level->id }}">
                                                {{ $level->{'name_' . config('app.locale')} }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-5">
                                    <label for="subject" class="form-label">{{ trans('levelsubject.label.subject') }}</label>
                                    <select class="form-select" id="subject" name="subject">
                                        <option selected disabled>{{ trans('levelsubject.select.subject') }}</option>
                                        @foreach ($subjects as $key => $subject)
                                            <option value="{{ $subject->id }}">
                                                {{ $subject->{'name_' . config('app.locale')} }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label for="name_ar" class="form-label">{{ trans('app.actions') }}</label>
                                    <button type="button" class="btn btn-md btn-danger btn-block" data-repeater-delete>
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-md btn-primary btn-block" data-repeater-create>
                                    <i class='tf-icons bx bx-plus'></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">{{ trans('app.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('app.create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="subjectsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('level.create') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.level-subjects.store') }}" method="POST">
                @csrf
                @method('POST')

                <input class="form-control" type="hidden" id="level_id" name="level_id"/>

                <div class="modal-body">
                    <div class="repeater" id="repeater">
                        <div data-repeater-list="list_level_subjects">
                            <div data-repeater-item class="row mb-3">

                                <div class="col-10">
                                    <label for="subject" class="form-label">{{ trans('levelsubject.label.subject') }}</label>
                                    <select class="form-select" name="subject_id">
                                        <option value="0">{{ trans('levelsubject.select.subject') }}</option>
                                        @foreach ($subjects as $key => $subject)
                                            <option value="{{ $subject->id }}">
                                                {{ $subject->{'name_' . config('app.locale')} }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <label class="form-label">{{ trans('app.actions') }}</label><br>
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

<div class="modal fade" id="editLevelModal{{ $level->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <form action="{{ route('dashboard.levels.update', 'test') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="id" name="id" class="form-control" value="{{ $level->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('level.edit') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="section_id" class="form-label">{{ trans('level.label.section') }}</label>
                            <select class="form-select" id="section_id" name="section_id"
                                aria-label="Default select example">
                                <option selected value="{{ $level->section->id }}">{{ $level->section->{'name_' . config('app.locale')} }}</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->{'name_' . config('app.locale')} }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="year" class="form-label">{{ trans('level.label.year') }}</label>
                            <select class="form-select" id="year" name="year" aria-label="Default select example">
                                {{-- <option selected value="{{ $level->year }}">
                                    @if ($level->year == 1)
                                        {{ trans('level.option.year.one') }}
                                    @elseif ($level->year == 2)
                                        {{ trans('level.option.year.two') }}
                                    @elseif ($level->year == 3)
                                        {{ trans('level.option.year.there') }}
                                    @elseif ($level->year == 4)
                                        {{ trans('level.option.year.foor') }}
                                    @elseif ($level->year == 5)
                                        {{ trans('level.option.year.five') }}
                                    @endif
                                </option> --}}
                                <option value="1" {{$level->year == 1 ? 'selected' : ''}}>{{ trans('level.option.year.one') }}</option>
                                <option value="2" {{$level->year == 2 ? 'selected' : ''}}>{{ trans('level.option.year.two') }}</option>
                                <option value="3" {{$level->year == 3 ? 'selected' : ''}}>{{ trans('level.option.year.there') }}</option>
                                <option value="4" {{$level->year == 4 ? 'selected' : ''}}>{{ trans('level.option.year.foor') }}</option>
                                <option value="5" {{$level->year == 5 ? 'selected' : ''}}>{{ trans('level.option.year.five') }}</option>
                            </select>
                        </div>

                        <div class="col-12 m-0 p-0 row">
                            <div class="col-6 mb-3">
                                <label for="name_ar" class="form-label">{{ trans('level.label.name_ar') }}</label>
                                <input type="text" id="name_ar" name="name_ar" class="form-control" value="{{ $level->name_ar }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="specialty_ar" class="form-label">{{ trans('level.label.specialty_ar') }}</label>
                                <input type="text" id="specialty_ar" name="specialty_ar" class="form-control" value="{{ $level->specialty_ar }}">
                            </div>
                        </div>
                        <div class="col-12 m-0 p-0 row">
                            <div class="col-6 mb-3">
                                <label for="name_en" class="form-label">{{ trans('level.label.name_en') }}</label>
                                <input type="text" id="name_en" name="name_en" class="form-control" value="{{ $level->name_fr }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="specialty_en" class="form-label">{{ trans('level.label.specialty_en') }}</label>
                                <input type="text" id="specialty_en" name="specialty_en" class="form-control" value="{{ $level->specialty_en }}">
                            </div>
                        </div>
                        <div class="col-12 m-0 p-0 row">
                            <div class="col-6 mb-3">
                                <label for="name_fr" class="form-label">{{ trans('level.label.name_fr') }}</label>
                                <input type="text" id="name_fr" name="name_fr" class="form-control" value="{{ $level->name_fr }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="specialty_fr" class="form-label">{{ trans('level.label.specialty_fr') }}</label>
                                <input type="text" id="specialty_fr" name="specialty_fr" class="form-control" value="{{ $level->specialty_fr }}">
                            </div>
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

@extends('layouts/contentNavbarLayout')

@section('title', trans('level.levels'))

@section('vendor-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.js"></script>
@endsection

@section('vendor-style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css" />
    <style>
        .hiddenRow {
            padding: 0 !important;
        }
    </style>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('level.levels') }}
    </h4>
@endsection

@section('content')
    @include('dashboard.level.create')
    <div class="card">
        <h5 class="card-header pt-0 mt-1">
            <form action="" method="GET" id="searchLevelForm">
                <div class="row  justify-content-between">
                    <div class="form-group col-md-4 mr-5 mt-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createLevelModal">
                            <span class="tf-icons bx bx-plus"></span>&nbsp; {{ trans('level.create') }}
                        </button>
                    </div>
                    <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="section_filter" class="form-label">{{ trans('level.select.section') }}</label>
                        <select class="form-select" id="section_filter" name="section_id"
                            aria-label="Default select example">
                            <option value="" {{ Request::get('role') == '' ? 'selected' : '' }}>{{ trans('app.all') }}
                            </option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}"
                                    {{ Request::get('section_id') == $section->id ? 'selected' : '' }}>
                                    {{ $section->{'name_' . config('app.locale')} }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="name" class="form-label">{{ trans('level.label.name') }}</label>
                        <input type="text" id="name" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-solid"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('level.placeholder.name') }}">
                    </div>
                </div>
            </form>
        </h5>
        <div class="table-responsive text-nowrap">
            {{--             <table class="table mb-2">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>{{ trans('level.name') }}</th>
                        <th>{{ trans('level.specialty') }}</th>
                        <th>{{ trans('level.name_en') }}</th>
                        <th>{{ trans('level.name_fr') }}</th>
                        <th>{{ trans('level.name_ar') }}</th>
                        <th>{{ trans('level.image') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($levels as $key => $level)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $level->name(Session::get('locale')) }}</td>
                            <td>{{ $level->specialty(Session::get('locale')) }}</td>
                            <td>{{ $level->name_ar }}</td>
                            <td>{{ $level->name_en }}</td>
                            <td>{{ $level->name_fr }}</td>
                            <td>Table cell</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info mx-1"
                                    data-bs-toggle="modal" data-bs-target="#editLevelModal{{ $level->id }}"
                                >
                                    <i class='bx bxs-edit'></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger mx-1"
                                    data-bs-toggle="modal" data-bs-target="#deleteLevelModal{{ $level->id }}"
                                >
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                        @include('dashboard.level.edit')
                        @include('dashboard.level.delete')
                    @endforeach
                </tbody>
            </table> --}}

            <table class="table table-condensed" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="width:10%;">#</th>
                        <th style="width:60%;">{{ trans('level.name') }}</th>
                        <th style="width:30%;">{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($years as $key => $year)
                        @if ($year->hasLevels())
                            <tr data-toggle="collapse" data-target="#demo{{ $key }}" class="accordion-toggle"
                                onclick="toggleIcon(this)">
                                <th scope="row"><i class='bx bx-chevron-down toggle-icon'></i></th>
                                <td>{{ $year->name(Session::get('locale')) }}</td>

                                <td>
                                    {{-- <button type="button" class="btn btn-sm btn-info mx-1" data-bs-toggle="modal"
                                    data-bs-target="#editLevelModal{{ $year->id }}">
                                    <i class='bx bxs-edit'></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger mx-1" data-bs-toggle="modal"
                                    data-bs-target="#deleteLevelModal{{ $year->id }}">
                                    <i class='bx bx-trash'></i>
                                </button> --}}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="hiddenRow">
                                    <div class="accordian-body collapse" id="demo{{ $key }}">
                                        <table class="table table-condensed">
                                            <tbody>
                                                @foreach ($year->levels()->get() as $key => $specialty)
                                                    <tr class="table-secondary">
                                                        <td style="width:10%;"></td>
                                                        <td style="width:60%;">
                                                            {{ $specialty->fullname(Session::get('locale')) }}
                                                        </td>
                                                        <td style="width:30%;">
                                                            <button type="button" class="btn btn-sm btn-info mx-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editLevelModal{{ $specialty->id }}">
                                                                <i class='bx bxs-edit'></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-danger mx-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteLevelModal{{ $specialty->id }}">
                                                                <i class='bx bx-trash'></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-warning mx-1"
                                                                onclick="setSubjectsList({{ $specialty->id }}, {{ json_encode($specialty->subjectsArray()) }})">
                                                                <i class='bx bx-book'></i>
                                                            </button>
                                                        </td>
                                                        @include('dashboard.level.edit', [
                                                            'level' => $specialty,
                                                        ])
                                                        @include('dashboard.level.delete', [
                                                            'level' => $specialty,
                                                        ])
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <th scope="row"></th>
                                <td>{{ $year->name(Session::get('locale')) }}</td>

                                <td>
                                    <button type="button" class="btn btn-sm btn-info mx-1" data-bs-toggle="modal"
                                        data-bs-target="#editLevelModal{{ $year->level()->id }}">
                                        <i class='bx bxs-edit'></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger mx-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteLevelModal{{ $year->level()->id }}">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning mx-1"
                                        onclick="setSubjectsList({{ $year->level()->id }}, {{ json_encode($year->level()->subjectsArray()) }})">
                                        <i class='bx bx-book'></i>
                                    </button>
                                </td>
                                @include('dashboard.level.edit', ['level' => $year->level()])
                                @include('dashboard.level.delete', ['level' => $year->level()])
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            {{ $years->links() }}
        </div>
    </div>

    @include('dashboard.level.subjects')
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            function submitForm() {
                $("#searchLevelForm").submit();
            }
            $('#name').on('keyup', function(event) {
                $("#name").focus();

                timer = setTimeout(function() {
                    submitForm();
                }, 1000);
            });

            $('#section_filter').on('change', function(event) {
                // $("#name").focus();

                timer = setTimeout(function() {
                    submitForm();
                }, 1000);

            });


        });

        function setSubjectsList(levelId, subjects) {
          var repeater = $("#repeater").repeater({
                initEmpty: true,
                defaultValues: {
                    'subject_id': 0,
                },
            });

            if (subjects.length) {
                repeater.setList(subjects);
            } else {
                repeater.setList([{
                    'subject_id': 0,
                }]);
            }
            //console.log(repeater.repeaterVal())
            $("#level_id").val(levelId);
            $("#subjectsModal").modal("show");
        }

        function toggleIcon(element) {
            // Find the icon within the clicked tr
            var icon = $(element).find('.toggle-icon');
            // Toggle between the down and up icons
            if (icon.hasClass('bx-chevron-down')) {
                icon.removeClass('bx-chevron-down').addClass('bx-chevron-up');
            } else {
                icon.removeClass('bx-chevron-up').addClass('bx-chevron-down');
            }
        }
    </script>
@endsection

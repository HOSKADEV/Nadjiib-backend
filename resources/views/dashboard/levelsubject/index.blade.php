@extends('layouts/contentNavbarLayout')

@section('title', trans('levelsubject.levelsubjects'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.1.2/jquery.repeater.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-repeater/dist/js/repeater.min.js"></script> --}}
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('levelsubject.levelsubjects') }}
    </h4>
@endsection

@section('content')
    @include('dashboard.levelsubject.create')
    <div class="card">
        <h5 class="card-header pt-0 mt-1">
            <div class="row  justify-content-between">
                <div class="form-group col-md-4 mr-5 mt-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#createLevelSubjectModal">
                        <span class="tf-icons bx bx-plus"></span>&nbsp; {{ trans('levelsubject.create') }}
                    </button>
                </div>
                <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                    <form action="" method="GET" id="searchLevelSubjectForm">
                        <label for="name" class="form-label">{{ trans('levelsubject.label.name') }}</label>
                        <input type="text" id="name" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-solid"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('levelsubject.placeholder.name') }}">
                    </form>
                </div>
            </div>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table mb-2">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>{{ trans('levelsubject.level.name_ar') }}</th>
                        <th>{{ trans('levelsubject.level.name_en') }}</th>
                        <th>{{ trans('levelsubject.subject.name_en') }}</th>
                        <th>{{ trans('levelsubject.subject.name_en') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($levelSubjects as $key => $levelSubject)
                        <tr>
                            <td scope="row">1</td>
                            <td>{{ $levelSubject->level->name_ar }}</td>
                            <td>{{ $levelSubject->level->name_en }}</td>
                            <td>{{ $levelSubject->subject->name_ar }}</td>
                            <td>{{ $levelSubject->subject->name_en }}</td>

                            <td>
                                {{-- <button type="button" class="btn btn-sm btn-info mx-1" data-bs-toggle="modal"
                                    data-bs-target="#editSectionModal{{ $levelSubject->id }}">
                                    <i class='bx bxs-edit'></i>
                                </button> --}}
                                <button type="button" class="btn btn-sm btn-danger mx-1" data-bs-toggle="modal"
                                    data-bs-target="#deleteLevelSubjectModal{{ $levelSubject->id }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>

                        </tr>
                        @include('dashboard.levelsubject.delete')
                    @endforeach
                </tbody>
                {{-- <tbody>
                    @foreach ($sections as $key => $section)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $section->name_ar }}</td>
                            <td>{{ $section->name_en }}</td>
                            <td>{{ $section->name_fr }}</td>
                            <td>Table cell</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info mx-1"
                                    data-bs-toggle="modal" data-bs-target="#editSectionModal{{ $section->id }}"
                                >
                                    <i class='bx bxs-edit'></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger mx-1"
                                    data-bs-toggle="modal" data-bs-target="#deleteSectionModal{{ $section->id }}"
                                >
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                        @include('dashboard.section.edit')
                        @include('dashboard.section.delete')
                    @endforeach
                </tbody> --}}
            </table>
            {{ $levelSubjects->links() }}
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#repeater').repeater({
                show: function() {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                    // if(confirm('Are you sure you want to delete this element?')) {
                    // }
                }
            });

            $('#name').on('keyup', function(event) {
                $("#name").focus();

                timer = setTimeout(function() {
                    submitForm();
                }, 1000);

                function submitForm() {
                    $("#searchSectionForm").submit();
                }
            });
        });
    </script>
@endsection

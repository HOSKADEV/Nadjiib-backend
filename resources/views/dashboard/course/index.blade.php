@extends('layouts/contentNavbarLayout')

@section('title', trans('course.courses'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('course.courses') }}
    </h4>
@endsection

@section('content')
    {{-- @include('dashboard.coupon.create') --}}
    <div class="card">
        <h5 class="card-header pt-0 mt-2">
            <form action="" method="GET" id="searchCourseForm">
                <div class="row">
                    <div class="form-group col-md-3" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="name" class="form-label">{{ trans('course.label.status') }}</label>
                        <select class="form-select" id="status" name="status" aria-label="Default select example">
                            <option value="{{ Request::get('status') != '' ? Request::get('status') : '' }}"
                                {{ Request::get('status') != '' ? 'selected' : '' }}>
                                {{ Request::get('status') != '' ? (Request::get('status') == 'ACTIVE' ? trans('app.statuss.active') : trans('app.statuss.inactive')) : trans('course.select.status') }}
                            </option>
                            <option value="">{{ trans('app.all') }}</option>
                            <option value="ACTIVE">{{ trans('user.statuss.active') }}</option>
                            <option value="INACTIVE">{{ trans('user.statuss.inactive') }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="subject" class="form-label">{{ trans('course.label.subject') }}</label>
                        <select class="form-select" id="subject" name="subject" aria-label="Default select example">
                            <option value="">{{ trans('course.select.subject') }}</option>
                            <option value="">{{ trans('app.all') }}</option>

                            @foreach ($subjects as $item => $subject)
                                <option value="{{ $subject->{'name_' . config('app.locale')} }}"
                                    {{ $subject->{'name_' . config('app.locale')} == Request::get('subject') ? 'selected' : '' }}>
                                    {{ $subject->{'name_' . config('app.locale')} }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="teacher" class="form-label">{{ trans('course.label.teacher') }}</label>
                        <select class="form-select" id="teacher" name="teacher" aria-label="Default select example">
                            <option value="">{{ trans('course.select.teacher') }}</option>
                            <option value="">{{ trans('app.all') }}</option>

                            @foreach ($teachers as $item => $teacher)
                                <option value="{{ $teacher->user->name }}"
                                    {{ $teacher->user->name == Request::get('teacher') ? 'selected' : '' }}>
                                    {{ $teacher->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="search" class="form-label">{{ trans('user.label.search') }}</label>
                        <input type="text" id="search" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-solid"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('user.placeholder.search') }}">
                    </div>
                </div>
            </form>

        </h5>
        <div class="table-responsive text-nowrap">

            <table class="table mb-2">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>{{ trans('course.name') }}</th>
                        <th>{{ trans('course.subject') }}</th>
                        <th>{{ trans('course.teacher') }}</th>
                        <th>{{ trans('course.price') }}</th>
                        <th>{{ trans('course.status') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $key => $course)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->subject->{'name_' . config('app.locale')} }}</td>
                            <td>{{ $course->teacher->user->name }}</td>
                            <td>{{ $course->price }}</td>

                            <td>
                                <span
                                    class="badge rounded-pill text-capitalize bg-{{ $course->status == 'ACTIVE' ? 'success' : 'danger' }}">
                                    {{ $course->status == 'ACTIVE' ? trans('app.status.Active') : trans('app.status.Inactive') }}
                                </span>
                            </td>

                            <td>

                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @if ($course->status == 'INACTIVE')
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#UpdateStatusModal{{ $course->id }}">
                                                {{-- <i class='bx bx-check-circle me-2'></i> --}}
                                                <i class='bx bxs-badge-check me-2'></i>
                                                {{-- <i class='bx bx-x'></i> --}}
                                                {{ trans('course.approved') }}
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                            data-bs-target="#UpdateStatusModal{{ $course->id }}">
                                            <i class='bx bx-x me-2'></i>
                                            {{ trans('course.reject') }}
                                        </a>
                                        @endif

                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                            data-bs-target="#deleteUserModal{{ $course->id }}">
                                            <i class="bx bx-trash me-2"></i>
                                            {{ trans('course.delete') }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{-- @include('dashboard.coupon.edit')
                        @include('dashboard.coupon.delete') --}}
                    @endforeach
                </tbody>
            </table>
            {{ $courses->links() }}
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#status').on('change', function(event) {
                // $("#name").focus();

                timer = setTimeout(function() {
                    submitForm();
                }, 1000);

            });

            $('#subject').on('change', function(event) {
                // $("#name").focus();

                timer = setTimeout(function() {
                    submitForm();
                }, 1000);

            });
            $('#teacher').on('change', function(event) {
                // $("#name").focus();

                timer = setTimeout(function() {
                    submitForm();
                }, 1000);

            });
            // search
            $('#search').on('keyup', function(event) {
                $("#search").focus();
                timer = setTimeout(function() {
                    submitForm();
                }, 4000);

            })

            function submitForm() {
                $("#searchCourseForm").submit();
            }
        });
    </script>

@endsection

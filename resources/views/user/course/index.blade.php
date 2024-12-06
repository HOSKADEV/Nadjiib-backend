@extends('layouts/contentNavbarLayout')

@section('title', trans('course.courses'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
    <script src="https://unpkg.com/htmx.org@2.0.0"
        integrity="sha384-wS5l5IKJBvK6sPTKa2WZ1js3d947pvWXbPJ1OmWfEuxLgeHcEbjUUA5i9V5ZkpCw" crossorigin="anonymous">
    </script>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">{{ trans('course.my_courses') }}</h4>
@endsection

@section('content')
    <div class="card">
        <h5 class="card-header pt-0 mt-2">
            <form action="" method="GET" id="searchCourseForm">
                <div class="row">
                  <div class="form-group col-md-3 mr-5 mt-4">
                    <a type="button" class="btn btn-primary" href="{{route('user.courses.create')}}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp; {{ trans('course.create') }}
                    </a>
                  </div>
                    <div class="form-group col-md-3" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="name" class="form-label">{{ trans('course.label.status') }}</label>
                        <select class="form-select" id="status" name="status" aria-label="Default select example">
                            <option value="">{{ trans('app.all') }}</option>
                            <option value="PENDING" {{ Request::get('status') == 'PENDING' ? 'selected' : '' }}>
                                {{ trans('app.status.Pending') }}</option>
                            <option value="ACCEPTED" {{ Request::get('status') == 'ACCEPTED' ? 'selected' : '' }}>
                                {{ trans('app.status.Accepted') }}</option>
                            <option value="REFUSED" {{ Request::get('status') == 'REFUSED' ? 'selected' : '' }}>
                                {{ trans('app.status.Refused') }}</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="subject" class="form-label">{{ trans('course.label.subject') }}</label>
                        <select class="form-select" id="subject" name="subject" aria-label="Default select example">
                            <option value="">{{ trans('app.all') }}</option>

                            @foreach ($subjects as $item => $subject)
                                <option value="{{ $subject->id }}"
                                    {{ $subject->id  == Request::get('subject') ? 'selected' : '' }}>
                                    {{ $subject->{'name_' . config('app.locale')} }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="search" class="form-label">{{ trans('user.label.search') }}</label>
                        <input type="text" id="search" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-solid"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('course.search') }}">
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
                            <td class="align-middle" style="direction: ltr">@money($course->price)</td>
                            <td>
                                @if ($course->status == 'PENDING')
                                    <span class="badge rounded-pill text-capitalize bg-warning">
                                        {{ trans('app.status.Pending') }}
                                    </span>
                                @elseif($course->status == 'ACCEPTED')
                                    <span class="badge rounded-pill text-capitalize bg-success">
                                        {{ trans('app.status.Accepted') }}
                                    </span>
                                @else
                                    <span class="badge rounded-pill text-capitalize bg-danger">
                                        {{ trans('app.status.Refused') }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                            href="{{ route('user.course.lessons' , $course->id) }}">
                                            <i class="bx bx-show me-2"></i>
                                            {{ trans('course.show') }}
                                        </a>

                                        <a class="dropdown-item" href="{{ url($course->image) }}">
                                            <i class='bx bx-image me-1'></i>
                                            {{ trans('course.image') }}
                                      </a>
                                        <a class="dropdown-item" href="{{ url($course->video) }}">
                                            <i class='bx bx-movie-play me-1'></i>
                                            {{ trans('course.video') }}
                                    </a>


                                      @if ($course->status != 'ACCEPTED')
                                          <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                              data-bs-target="#deleteCourseModal{{ $course->id }}">
                                              <i class="bx bx-trash me-2"></i>
                                              {{ trans('course.delete') }}
                                          </a>
                                      @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                        @include('dashboard.course.delete')
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
                }, 1000);

            })

            function submitForm() {
                $("#searchCourseForm").submit();
            }

            $('.image-input').on('change', function(event) {
                const id = $(this).attr('id').replace('image', '');
                //const fileInput = document.querySelector('.image-input');
                const fileInput = document.getElementById('image' + id);
                if (fileInput.files[0]) {
                    document.getElementById('uploaded-image' + id).src = window.URL.createObjectURL(
                        fileInput
                        .files[0]);
                }
            });
            $('.image-reset').on('click', function(event) {
                const id = $(this).attr('id').replace('reset', '');
                //const fileInput = document.querySelector('.image-input');
                const fileInput = document.getElementById('image' + id);
                fileInput.value = '';
                document.getElementById('uploaded-image' + id).src = document.getElementById('old-image' +
                    id).src;
            });
        });
    </script>

@endsection

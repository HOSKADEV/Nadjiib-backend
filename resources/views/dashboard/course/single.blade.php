@extends('layouts/contentNavbarLayout')

@section('title', trans('course.details'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">
        <span
            class="text-muted fw-light">{{ trans('app.dashboard') }}/{{ trans('course.courses') }}/</span>{{ $course->name }}
    </h4>
@endsection

@section('content')
    <div class="card">
        <h5 class="card-header py-2 mt-2">
            {{ trans('course.details') }}
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
        </h5>
        <hr class="m-0" />
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <label class="form-label">{{ trans('course.name') }}</label>
                    <p>{{ $course->name }}</p>
                </div>
                <div class="col-sm-12 col-md-3">
                    <label class="form-label">{{ trans('course.subject') }}</label>
                    <p>{{ $course->subject->name_ar }}</p>
                </div>
                <div class="col-sm-12 col-md-3">
                    <label class="form-label">{{ trans('course.teacher') }}</label>
                    <p>{{ $course->teacher->user->name }}</p>
                </div>
                <div class="col-sm-12 col-md-2">
                    <label class="form-label">{{ trans('course.price') }}</label>
                    <p class="align-middle" style="direction: ltr">@money($course->price)</p>
                </div>
                <div class="col-sm-12 col-md-12">
                    <label class="form-label">{{ trans('course.description') }}</label>
                    <p>{{ $course->description }}</p>
                </div>
                <div class="col-sm-12 col-md-6" height="100px">
                    <label class="form-label">{{ trans('course.image') }}</label>
                    <img class="img-fluid mx-auto" src="https://elmadrasah.com/cdn/shop/articles/10.jpg?v=1701684565"
                        alt="" srcset="" height="100px">
                </div>
                <div class="col-sm-12 col-md-6" height="100px">
                    <label class="form-label">{{ trans('course.video') }}</label>
                    <img class="img-fluid mx-auto" src="https://elmadrasah.com/cdn/shop/articles/10.jpg?v=1701684565"
                        alt="" srcset="" height="100px">
                </div>
            </div>
        </div>
    </div>

    <div class="card my-3">
        <h5 class="card-header py-2 mt-2">
            {{ trans('course.lessons') }}
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table mb-2">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th class="text-center">{{ trans('lesson.title') }}</th>
                        {{-- <th>{{ trans('lesson.description') }}</th> --}}
                        <th class="text-center">{{ trans('lesson.files') }}</th>
                        <th class="text-center">{{ trans('lesson.videos') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($course->lessons as $item => $lesson)
                        <tr>
                            <th scope="row">{{ trans('lesson.lessonNumber.' . $loop->iteration) }}</th>
                            <td class="text-center">{{ $lesson->title }}</td>
                            {{-- <td class="text-center">
                                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar"
                                    class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                            </td>
                            <td class="text-center">
                                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar"
                                    class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                            </td> --}}

                            <td class="text-center">{{ trans('lesson.files') }}</td>
                            <td class="text-center">{{ trans('lesson.videos') }}</td>
                            <td>Actions</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $course->lessons->links() }} --}}
        </div>

    </div>
@endsection

@section('scripts')

@endsection

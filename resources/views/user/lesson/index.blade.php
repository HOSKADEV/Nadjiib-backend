@extends('layouts/contentNavbarLayout')

@section('title', trans('lesson.lessons'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">
        <span class="text-muted fw-light">{{ $course->name }} / </span>{{ trans('lesson.lessons') }}
    </h4>
@endsection
@section('content')
    <div class="card">
        <h5 class="card-header pt-0 mt-1">
            <div class="row  justify-content-between">
              @if ($course->status != 'REFUSED')
              <div class="form-group col-md-3 mr-5 mt-4">
                <a type="button" class="btn btn-primary" href="{{route('user.lessons.create', $course->id)}}">
                    <span class="tf-icons bx bx-plus"></span>&nbsp; {{ trans('lesson.create') }}
                </a>
              </div>
              @endif


                <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                    <form action="" method="GET" id="searchNoticeForm">
                        <label for="name" class="form-label">{{ trans('lesson.search') }}</label>
                        <input type="text" id="name" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-'.Session::get('theme') == 'dark' ? 'regular' : 'solid' .'"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('lesson.placeholder') }}">
                    </form>
                </div>
            </div>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table mb-2">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>{{ trans('lesson.title') }}</th>
                        <th>{{ trans('lesson.description') }}</th>
                        <th>{{ trans('lesson.attachments') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lessons as $key => $lesson)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $lesson->title }}</td>
                            <td>
                                <textarea rows="2" class="form-control">{{ $lesson->description }}</textarea>
                            </td>
                            <td>
                                @foreach ($lesson->videos as $video)
                                    <a href="{{ $video->url() }}">
                                        <img src="{{ asset(Session::get('theme') == 'dark' ? 'assets/icons/file-video-regular.svg' : 'assets/icons/file-video-solid.svg') }}"
                                            height="30px" width="30px" />
                                    </a>
                                @endforeach

                                @foreach ($lesson->files as $file)
                                    @if ($file->type() == 'img')
                                        <a href="{{ $file->url() }}">
                                            <img src="{{ asset(Session::get('theme') == 'dark' ? 'assets/icons/file-image-regular.svg' : 'assets/icons/file-image-solid.svg') }}"
                                                height="30px" width="30px" />
                                        </a>
                                    @elseif ($file->type() == 'doc')
                                        <a href="{{ $file->url() }}">
                                            <img src="{{ asset(Session::get('theme') == 'dark' ? 'assets/icons/file-word-regular.svg' : 'assets/icons/file-word-solid.svg') }}"
                                                height="30px" width="30px" />
                                        </a>
                                    @elseif ($file->type() == 'xls')
                                        <a href="{{ $file->url() }}">
                                            <img src="{{ asset(Session::get('theme') == 'dark' ? 'assets/icons/file-excel-regular.svg' : 'assets/icons/file-excel-solid.svg') }}"
                                                height="30px" width="30px" />
                                        </a>
                                    @elseif ($file->type() == 'ppt')
                                        <a href="{{ $file->url() }}">
                                            <img src="{{ asset(Session::get('theme') == 'dark' ? 'assets/icons/file-powerpoint-regular.svg' : 'assets/icons/file-powerpoint-solid.svg') }}"
                                                height="30px" width="30px" />
                                        </a>
                                    @elseif ($file->type() == 'pdf')
                                        <a href="{{ $file->url() }}">
                                            <img src="{{ asset(Session::get('theme') == 'dark' ? 'assets/icons/file-pdf-regular.svg' : 'assets/icons/file-pdf-solid.svg') }}"
                                                height="30px" width="30px" />
                                        </a>
                                    @elseif ($file->type() == 'zip')
                                        <a href="{{ $file->url() }}">
                                            <img src="{{ asset(Session::get('theme') == 'dark' ? 'assets/icons/file-zipper-regular.svg' : 'assets/icons/file-zipper-solid.svg') }}"
                                                height="30px" width="30px" />
                                        </a>
                                    @else
                                        <a href="{{ $file->url() }}">
                                            <img src="{{ asset(Session::get('theme') == 'dark' ? 'assets/icons/file-regular.svg' : 'assets/icons/file-solid.svg') }}"
                                                height="30px" width="30px" />
                                        </a>
                                    @endif
                                @endforeach

                            </td>
                            <td>
                              <button type="button" class="btn btn-sm btn-danger mx-1" data-bs-toggle="modal"
                              data-bs-target="#deleteLessonModal{{ $lesson->id }}">
                              <i class='bx bx-trash'></i>
                          </button>
                            </td>
                        </tr>

                        @include('user.lesson.delete')
                    @endforeach
                </tbody>
            </table>
            {{ $lessons->links() }}
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function() {
            $('#name').on('keyup', function(event) {
                $("#name").focus();

                timer = setTimeout(function() {
                    submitForm();
                }, 1000);

                function submitForm() {
                    $("#searchNoticeForm").submit();
                }
            });

            $('.submit-btn').on('click', function(event) {

                const form = $(`#deleteLessonForm${$(this).data('lesson')}`);
                const submitButton = $(`#submitBtn${$(this).data('lesson')}`);
                const closeButton = $(`#closeBtn${$(this).data('lesson')}`);

                closeButton.hide();

                submitButton.html(`<div class="spinner-border" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>`);

                submitButton.prop('disabled', true);

                setTimeout(() => {
                    form.submit();
                }, 0);
            });
        });
    </script>
@endsection

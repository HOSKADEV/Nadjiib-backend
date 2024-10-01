@extends('layouts/contentNavbarLayout')

@section('title', trans('lesson.lessons'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
    <script src="https://kit.fontawesome.com/cec0d2ede3.js" crossorigin="anonymous"></script>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('lesson.lessons') }}
    </h4>
@endsection
@section('content')
    <div class="card">
        <h5 class="card-header pt-0 mt-1">
            <div class="row  justify-content-between">
                {{-- <div class="form-group col-md-4 mr-5 mt-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNoticeModal">
                        <span class="tf-icons bx bx-plus"></span>&nbsp; {{ trans('lesson.create') }}
                    </button>
                </div> --}}

                <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                    <form action="" method="GET" id="searchNoticeForm">
                        <label for="name" class="form-label">{{ trans('lesson.label.title') }}</label>
                        <input type="text" id="name" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-solid"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('lesson.placeholder.title') }}">
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
                                      <i class="bx bxs-movie-play bx-md" style="color: #696cff"></i>
                                    </a>
                                @endforeach

                                @foreach ($lesson->files as $file)
                                @if ($file->type() == 'img' )
                                <a href="{{ $file->url() }}">
                                  <i class="bx bxs-file-image bx-md" style="color: #03c3ec"></i>
                                </a>
                                @elseif ($file->type() == 'doc')
                                <a href="{{ $file->url() }}">
                                  <i class="bx bxs-file-doc bx-md" style="color: #356AAA"></i>
                                </a>
                                @elseif ($file->type() == 'xls')
                                <a href="{{ $file->url() }}">
                                  <i class="bx bxs-file bx-md" style="color: #1F7244"></i>
                                </a>
                                @elseif ($file->type() == 'ppt')
                                <a href="{{ $file->url() }}">
                                  <i class="bx bxs-file bx-md" style="color: #D24625"></i>
                                </a>
                                @elseif ($file->type() == 'pdf')
                                <a href="{{ $file->url() }}">
                                  <i class="bx bxs-file-pdf bx-md" style="color: #B30B00"></i>
                                </a>
                                @else
                                <a href="{{ $file->url() }}">
                                  <i class="bx bxs-file-blank bx-md" style="color: #8592a3"></i>
                                </a>
                                @endif

                                @endforeach

                            </td>
                        </tr>
                    @endforeach

                    {{-- @include('dashboard.lesson.files')
                    @include('dashboard.lesson.videos') --}}
                </tbody>
            </table>
            {{ $lessons->links() }}
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all modals
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                new bootstrap.Modal(modal);
            });

            // Initialize all carousels
            var carousels = document.querySelectorAll('.carousel');
            carousels.forEach(function(carousel) {
                new bootstrap.Carousel(carousel, {
                    interval: false // Disable auto-sliding
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#name').on('keyup', function(event) {
                $("#name").focus();

                timer = setTimeout(function() {
                    submitForm();
                }, 500);

                function submitForm() {
                    $("#searchNoticeForm").submit();
                }
            });
        });
    </script>
@endsection

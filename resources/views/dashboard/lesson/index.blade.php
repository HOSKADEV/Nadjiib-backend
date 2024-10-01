@extends('layouts/contentNavbarLayout')

@section('title', trans('lesson.lessons'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
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
                                @php
                                    $videos = $lesson->videos; // Assuming this function exists and returns an array of video objects
                                    $files = $lesson->files; // Assuming this function exists and returns an array of file objects
                                @endphp

                            <td>
                                <!-- Video button -->
                                <button type="button" class="btn btn-sm btn-info mx-1" data-bs-toggle="modal"
                                    data-bs-target="#videoModal{{ $lesson->id }}">
                                    <i class='bx bxs-movie-play'></i>
                                </button>

                                <!-- File button -->
                                <button type="button" class="btn btn-sm btn-danger mx-1" data-bs-toggle="modal"
                                    data-bs-target="#fileModal{{ $lesson->id }}">
                                    <i class='bx bxs-file'></i>
                                </button>
                            </td>

                            <!-- Video Modal -->
                            <div class="modal fade" id="videoModal{{ $lesson->id }}" tabindex="-1"
                                aria-labelledby="videoModalLabel{{ $lesson->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="videoModalLabel{{ $lesson->id }}">Videos for
                                                Lesson {{ $lesson->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if (count($videos) > 0)
                                                <div id="videoCarousel{{ $lesson->id }}" class="carousel slide"
                                                    data-bs-ride="carousel">
                                                    <div class="carousel-inner">
                                                        @foreach ($videos as $index => $video)
                                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                                <video class="d-block w-100" controls>
                                                                    <source src="{{ $video->url() }}"
                                                                        type="video/{{ $video->extension }}">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @if (count($videos) > 1)
                                                        <button class="carousel-control-prev" type="button"
                                                            data-bs-target="#videoCarousel{{ $lesson->id }}"
                                                            data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon"
                                                                aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button"
                                                            data-bs-target="#videoCarousel{{ $lesson->id }}"
                                                            data-bs-slide="next">
                                                            <span class="carousel-control-next-icon"
                                                                aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button>
                                                    @endif
                                                </div>
                                            @else
                                                <p>No videos available for this lesson.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- File Modal -->
                            <div class="modal fade" id="fileModal{{ $lesson->id }}" tabindex="-1"
                                aria-labelledby="fileModalLabel{{ $lesson->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="fileModalLabel{{ $lesson->id }}">Documents for
                                                Lesson {{ $lesson->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if (count($files) > 0)
                                                <div id="fileCarousel{{ $lesson->id }}" class="carousel slide"
                                                    data-bs-ride="carousel">
                                                    <div class="carousel-inner">
                                                        @foreach ($files as $index => $file)
                                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                                <div class="text-center mb-3">
                                                                    <h6>{{ $file->filename }}</h6>
                                                                    <a href="{{ $file->url() }}"
                                                                        class="btn btn-primary btn-sm" download>Download</a>
                                                                </div>
                                                                <embed src="{{ $file->url() }}"
                                                                    type="application/{{ $file->extension }}"
                                                                    width="100%" height="600px" />
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @if (count($files) > 1)
                                                        <button class="carousel-control-prev" type="button"
                                                            data-bs-target="#fileCarousel{{ $lesson->id }}"
                                                            data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon"
                                                                aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button"
                                                            data-bs-target="#fileCarousel{{ $lesson->id }}"
                                                            data-bs-slide="next">
                                                            <span class="carousel-control-next-icon"
                                                                aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button>
                                                    @endif
                                                </div>
                                            @else
                                                <p>No documents available for this lesson.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
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

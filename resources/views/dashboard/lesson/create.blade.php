@extends('layouts/contentNavbarLayout')

@section('vendor-script')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/vendor/js/dropzone.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/stepper.js') }}"></script>
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/dropzone.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/stepper.css') }}" type="text/css" />
@endsection

@section('content')
    <div class="container py-8">
        <div class="align-text-center">
            <h2 class="mb-8 my-4">{{ __('lesson.create_title') }}</h2>
        </div>
        <div class="row">
            <div class="col-12 mb-6">
                <div class="bs-stepper wizard-vertical vertical mt-2">
                    <div class="bs-stepper-header">
                        <div class="step" data-target="#create-lesson">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">{{ __('lesson.create_lesson') }}</span>
                                    <span class="bs-stepper-subtitle">{{ __('lesson.lesson_details') }}</span>
                                </span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#upload-video">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">{{ __('lesson.upload_video') }}</span>
                                    <span class="bs-stepper-subtitle">{{ __('lesson.video_upload') }}</span>
                                </span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#upload-files">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">{{ __('lesson.upload_files') }}</span>
                                    <span class="bs-stepper-subtitle">{{ __('lesson.files_upload') }}</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <form onsubmit="event.preventDefault()" action="#" enctype="multipart/form-data" id="lesson_form">
                            <div id="create-lesson" class="content">
                                <div class="content-header mb-4">
                                    <h6 class="mb-0">{{ __('lesson.create_lesson') }}</h6>
                                    <small>{{ __('lesson.enter_lesson_details') }}</small>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="course_id" class="form-label">{{ __('lesson.course') }}</label>
                                            <input name="course_id" id="course_id" value="{{$course->id}}" hidden>
                                            <input value="{{$course->name}}" class="form-control" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">{{ __('lesson.lesson_name') }}</label>
                                            <input type="text" name="title" id="title" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="description" class="form-label">{{ __('lesson.lesson_description') }}</label>
                                        <textarea name="description" id="description" style="height:122px" class="form-control"></textarea>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between">
                                        <button class="btn btn-primary" id="lesson_submit_btn">
                                            <i class="bx bx-save bx-sm ms-sm-n2 me-sm-2"></i>
                                            <span class="align-middle d-sm-inline-block d-none">{{ __('lesson.save') }}</span>
                                        </button>
                                        <button class="btn btn-primary btn-next" id="lesson_next_btn" disabled>
                                            <span class="align-middle d-sm-inline-block d-none me-sm-2">{{ __('lesson.next') }}</span>
                                            <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div id="upload-video" class="content">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">{{ __('lesson.video_upload') }}</h6>
                                <small>{{ __('lesson.select_lesson_video') }}</small>
                            </div>
                            <div class="row g-6">
                                <div class="col-12 mb-2">
                                    <form class="dropzone" id="video-form" action="{{ route('dashboard.lesson.video') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="dz-message needsclick col-12">
                                            {{ __('lesson.video_dropzone_message') }}
                                            <span class="note needsclick">{{ __('lesson.video_dropzone_note') }}</span>
                                        </div>
                                        <div class="fallback">
                                            <input type="file" name="video" class="form-control" accept="video/*">
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-primary" id="video_submit_btn">
                                        <i class="bx bx-upload bx-sm ms-sm-n2 me-sm-2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">{{ __('lesson.upload') }}</span>
                                    </button>
                                    <button class="btn btn-primary btn-next" id="video_next_btn" disabled>
                                        <span class="align-middle d-sm-inline-block d-none me-sm-2">{{ __('lesson.next') }}</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="upload-files" class="content">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">{{ __('lesson.lesson_files') }}</h6>
                                <small>{{ __('lesson.select_lesson_files') }}</small>
                            </div>
                            <div class="row g-6">
                                <div class="col-12 mb-2">
                                    <form class="dropzone" id="files-form" action="{{ route('dashboard.lesson.files') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="dz-message needsclick col-12">
                                            {{ __('lesson.files_dropzone_message') }}
                                            <span class="note needsclick">{{ __('lesson.files_dropzone_note') }}</span>
                                        </div>
                                        <div class="fallback">
                                            <input type="file" name="files[]" class="form-control" multiple>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-primary" id="files_submit_btn">
                                        <i class="bx bx-upload bx-sm ms-sm-n2 me-sm-2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">{{ __('lesson.upload') }}</span>
                                    </button>
                                    <a class="btn btn-success" href="{{route('dashboard.course.lessons' , $course->id)}}">{{ __('lesson.finish') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            var stepper = new Stepper($('.bs-stepper')[0])

            $(document).on('click', '.btn-next', function() {
                stepper.next();
            })

            $(document).on('click', '.btn-prev', function() {
                stepper.previous();
            })

            $('#lesson_submit_btn').on('click', function() {
                var queryString = new FormData($("#lesson_form")[0]);
                $.ajax({
                    url: '{{ route('dashboard.lessons.store') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: queryString,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 1) {
                            $(this).prop('disabled', true);
                            $('#lesson_next_btn').prop('disabled', false);
                        } else {
                            Swal.fire(
                                "{{ __('common.error') }}",
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        Swal.fire(
                            "{{ __('common.error') }}",
                            errors.message,
                            'error'
                        );
                    }
                });
            });
        })
    </script>
@endsection

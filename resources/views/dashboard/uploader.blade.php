@extends('layouts.blankLayout')

@section('vendor-script')
    {{-- <script src="{{asset('assets/vendor/js/wizard.js')}}"></script> --}}
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/vendor/js/dropzone.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/stepper.js') }}"></script>
@endsection

@section('page-style')
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/css/dropzone.css') }}" type="text/css" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/stepper.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/progress.css') }}" type="text/css" />
@endsection



@section('content')
    <div class="container py-8">
        <div class="align-text-center">
            <h2 class="mb-8 my-4">Create A new Lesson</h2>
        </div>
        <div class="row">
            <!-- Vertical Wizard -->
            <div class="col-12 mb-6">
                {{-- <small class="text-light fw-medium">Vertical</small> --}}
                <div class="bs-stepper wizard-vertical vertical mt-2">
                    <div class="bs-stepper-header">
                        <div class="step" data-target="#create-lesson">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Create Lesson</span>
                                    <span class="bs-stepper-subtitle">Lesson Details</span>
                                </span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#upload-video">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Upload Video</span>
                                    <span class="bs-stepper-subtitle">Lesson Video Upload</span>
                                </span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#upload-files">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Upload Files</span>
                                    <span class="bs-stepper-subtitle">Lesson Files Upload</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <form onsubmit="event.preventDefault()" action="#" enctype="multipart/form-data"
                            id="lesson_form">
                            <!-- Account Details -->
                            <div id="create-lesson" class="content">
                                <div class="content-header mb-4">
                                    <h6 class="mb-0">Create Lesson</h6>
                                    <small>Enter Your Lesson Details.</small>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="course_id" class="form-label">Course</label>
                                            <select name="course_id" id="course_id" class="form-select">
                                                <option value="">Select a course</option>
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Lesson Name</label>
                                            <input type="text" name="title" id="title" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="description" class="form-label">Lesson Description</label>
                                        <textarea name="description" id="description" style="height:122px" class="form-control"></textarea>

                                    </div>
                                    <div class="col-12 d-flex justify-content-between">
                                        <button class="btn btn-primary" id="lesson_submit_btn">
                                            <i class="bx bx-save bx-sm ms-sm-n2 me-sm-2"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Save</span>
                                        </button>
                                        <button class="btn btn-primary btn-next" id="lesson_next_btn" disabled>
                                            <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span>
                                            <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Personal Info -->

                        <div id="upload-video" class="content">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Video Upload</h6>
                                <small>Select Lesson video.</small>
                            </div>
                            <div class="row g-6">
                                <div class="col-12 mb-2">
                                    <form class="dropzone" id="video-form" action="{{ url('/lesson/video/upload') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="dz-message needsclick col-12">
                                            Drop video file here or click to upload
                                            <span class="note needsclick">Only one video file is accepted</span>
                                        </div>
                                        <div class="fallback">
                                            <input type="file" name="video" class="form-control" accept="video/*">
                                        </div>

                                    </form>

                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-primary" id="video_submit_btn">
                                        <i class="bx bx-upload bx-sm ms-sm-n2 me-sm-2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Upload</span>
                                    </button>
                                    <button class="btn btn-primary btn-next" id="video_next_btn" disabled>
                                        <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Social Links -->
                        <div id="upload-files" class="content">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Lesson Files</h6>
                                <small>Select Lesson files.</small>
                            </div>
                            <div class="row g-6">
                                <div class="col-12 mb-2">
                                    <form class="dropzone" id="files-form" action="{{ url('/lesson/files/upload') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="dz-message needsclick col-12">
                                            Drop files here or click to upload
                                            <span class="note needsclick">Maximum of 15 files are accepted</span>
                                        </div>
                                        <div class="fallback">
                                            <input type="file" name="files[]" class="form-control"
                                                {{-- accept="" --}} multiple>
                                        </div>

                                    </form>

                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-primary" id="files_submit_btn">
                                        <i class="bx bx-upload bx-sm ms-sm-n2 me-sm-2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Upload</span>
                                    </button>
                                    <a class="btn btn-success" href="{{ url('/uploader') }}">Finish</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /Vertical Wizard -->
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
                //console.log(queryString);
                $.ajax({
                    url: '{{ url('lesson/create') }}',
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
                            //console.log(response.message);
                            Swal.fire(
                                "{{ __('Error') }}",
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        //console.log(errors);
                        Swal.fire(
                            "{{ __('Error') }}",
                            errors.message,
                            'error'
                        );
                        // Render the errors with js ...
                    }


                });

            });

            function trackUploadProgress() {
                let progress = 0;

                function checkUploadProgress() {
                    $.ajax({
                        url: '/upload-progress',
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            progress = response.progress;
                            $('.progress-bar').css('width', response.progress + '%')
                                .attr('aria-valuenow', response.progress)
                                .text(Math.round(response.progress) + '%');
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Progress Error',
                                text: 'Could not retrieve upload progress'
                            });
                        }
                    });
                }

                while (progress < 100) {
                    setTimeout(checkUploadProgress, 500);
                }

                startCompression();
            }

            function startCompression() {
                // Close upload progress Swal
                Swal.close();

                // Show compression progress Swal
                Swal.fire({
                    title: 'Compressing Video',
                    html: `
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
                `,
                    showConfirmButton: false,
                    allowOutsideClick: false
                });

                // Start tracking compression progress
                trackCompressionProgress();
            }

            function trackCompressionProgress() {
                let progress = 0;

                function checkCompressionProgress() {
                    $.ajax({
                        url: '/compression-progress',
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            progress = response.progress;
                            $('.progress-bar').css('width', response.progress + '%')
                                .attr('aria-valuenow', response.progress)
                                .text(Math.round(response.progress) + '%');
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Progress Error',
                                text: 'Could not retrieve compression progress'
                            });
                        }
                    });
                }

                while (progress < 100) {
                    setTimeout(checkCompressionProgress, 500);
                }
                // Compression complete, show success
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Video uploaded and compressed successfully!'
                });

            }

            $('#video_submit_btn').on('click', function(e) {
                e.preventDefault();

                // Check if file is selected
                /*  if ($('#videoForm')[0].files.length === 0) {
                     Swal.fire({
                         icon: 'warning',
                         title: 'No File Selected',
                         text: 'Please choose a video file first.'
                     });
                     return;
                 } */

                // Show initial upload progress Swal
                Swal.fire({
                    title: 'Uploading Video',
                    html: `
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
                `,
                    showConfirmButton: false,
                    allowOutsideClick: false
                });

                // Start upload process
                trackUploadProgress();
            });
        })
    </script>
@endsection

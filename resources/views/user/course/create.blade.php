@extends('layouts/contentNavbarLayout')

@section('vendor-script')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/vendor/js/dropzone.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/droparea.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/stepper.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/dropzone.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/droparea.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/stepper.css') }}" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
    <style>
        .bootstrap-select>.dropdown-toggle {
            color: #697a8d !important;
            background-color: #fff !important;
            background-clip: padding-box !important;
            border: 1px solid #d9dee3 !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <h5>{{ __('course.create_course_wizard') }}</h5>
        </div>

        <!-- Course Creation Wizard -->
        <div class="col-12 mb-6">
            <div class="bs-stepper wizard-numbered mt-2">
                <div class="bs-stepper-header">
                    <div class="step" data-target="#course-details">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">{{ __('course.course_details') }}</span>
                                <span class="bs-stepper-subtitle">{{ __('course.enter_course_information') }}</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="bx bx-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#course-image">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">{{ __('course.course_image') }}</span>
                                <span class="bs-stepper-subtitle">{{ __('course.upload_course_image') }}</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="bx bx-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#course-preview">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">3</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">{{ __('course.course_preview') }}</span>
                                <span class="bs-stepper-subtitle">{{ __('course.upload_preview_video') }}</span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <!-- Course Details -->
                    <div id="course-details" class="content">
                      <form onsubmit="event.preventDefault()" action="#" enctype="multipart/form-data" id="course_form">
                        <div class="row g-6">
                            <div class="col-sm-6">
                                <label class="form-label" for="name">{{ __('course.course_name') }}</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="{{ __('course.enter_course_name') }}" />
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="type_subject">{{ __('course.course_type') }}</label>
                                <select class="form-select" id="type_subject" name="type_subject">
                                    <option value="academic">{{ __('course.academic') }}</option>
                                    <option value="extracurricular">{{ __('course.extracurricular') }}</option>
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="price">{{ __('course.course_price') }}</label>
                                <input type="number" id="price" name="price" class="form-control" placeholder="{{ __('course.enter_course_price') }}" />
                            </div>

                            <div class="col-sm-6" id="levels_div">
                                <label class="form-label" for="levels_ids">{{ __('course.target_levels') }}</label>
                                <select class="form-control selectpicker" id="levels_ids"
                                    data-dropup-auto="false" multiple data-selected-text-format="count" multiple>
                                    @foreach ($sections as $section)
                                        <optgroup label="{{ $section->name(session('locale')) }}">
                                            @foreach ($section->levels as $level)
                                                <option value="{{ $level->id }}">
                                                    {{ $level->fullname(session('locale')) }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-6" id="sections_div">
                                <label class="form-label" for="sections_ids">{{ __('course.course_sections') }}</label>
                                <select class="form-control selectpicker" id="sections_ids"
                                    data-dropup-auto="false" multiple data-selected-text-format="count" multiple>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name(session('locale')) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-6" id="subjects_div">
                                <label class="form-label" for="subject_id">{{ __('course.course_subject') }}</label>
                                <select class="form-select" id="subject_id" name="subject_id">
                                    <option value="" selected>{{ __('course.select_subject') }}</option>
                                </select>
                            </div>

                            <div class="col-sm-6" id="subject_name_div">
                                <label class="form-label" for="name_subject">{{ __('course.subject_name') }}</label>
                                <input class="form-control" id="name_subject" name="name_subject" type="text" placeholder="{{ __('course.enter_subject_name') }}">
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="description">{{ __('course.course_description') }}</label>
                                <textarea name="description" id="description" class="form-control" placeholder="{{ __('course.enter_course_description') }}"></textarea>
                            </div>

                            <div class="col-12 d-flex justify-content-between">
                              <button class="btn btn-primary" id="course_submit_btn">
                                  <i class="bx bx-save bx-sm ms-sm-n2 me-sm-2"></i>
                                  <span class="align-middle d-sm-inline-block d-none">{{ __('course.save') }}</span>
                              </button>
                              <button class="btn btn-primary btn-next" id="course_next_btn" disabled>
                                  <span class="align-middle d-sm-inline-block d-none me-sm-2">{{ __('course.next') }}</span>
                                  <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                              </button>
                          </div>
                        </div>
                      </form>
                    </div>

                    <!-- Course Image -->
                    <div id="course-image" class="content">
                        <div class="row g-6">
                            <div class="col-12 mb-2">
                                <div id="drop-area">
                                    <p>{{ __('course.drag_drop_image_message') }}</p>
                                    <input type="file" id="fileElem" accept="image/*" style="display:none">
                                </div>

                                <div id="image-cropper"></div>
                                <div id="result"></div>
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                              <button class="btn btn-primary" id="image_submit_btn">
                                <i class="bx bx-upload bx-sm ms-sm-n2 me-sm-2"></i>
                                <span class="align-middle d-sm-inline-block d-none">{{ __('course.upload') }}</span>
                              </button>

                                <div id="controls">
                                    <button type="button" id="rotate-left" class="btn btn-icon btn-primary">
                                        <span class="tf-icons bx bx-rotate-left bx-22px"></span>
                                    </button>

                                    <button type="button" id="cancel-button" class="btn btn-icon btn-primary">
                                        <span class="tf-icons bx bx-x bx-22px"></span>
                                    </button>

                                    <button type="button" id="rotate-right" class="btn btn-icon btn-primary">
                                        <span class="tf-icons bx bx-rotate-right bx-22px"></span>
                                    </button>
                                </div>

                                <button class="btn btn-primary btn-next" id="image_next_btn" disabled>
                                  <span class="align-middle d-sm-inline-block d-none me-sm-2">{{ __('course.next') }}</span>
                                  <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                              </button>
                            </div>
                        </div>
                    </div>

                    <!-- Course Preview Video -->
                    <div id="course-preview" class="content">
                        <div class="row g-6">
                            <div class="col-12 mb-2">
                                <form class="dropzone" id="video-form" action="{{ route('user.course.video') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="dz-message needsclick col-12">
                                        {{ __('course.video_dropzone_message') }}
                                        <span class="note needsclick">{{ __('course.video_dropzone_note') }}</span>
                                    </div>
                                    <div class="fallback">
                                        <input type="file" name="video" class="form-control" accept="video/*">
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                              <button class="btn btn-primary" id="video_submit_btn">
                                <i class="bx bx-upload bx-sm ms-sm-n2 me-sm-2"></i>
                                <span class="align-middle d-sm-inline-block d-none">{{ __('course.upload') }}</span>
                            </button>
                            <button class="btn btn-success" id="video_next_btn" onclick="window.location.href='{{route('user.courses.index')}}'" disabled>{{ __('course.finish') }}</button>
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
            $('.selectpicker').selectpicker();
            $('#sections_div').hide();
            $('#subject_name_div').hide();
            var stepper = new Stepper($('.bs-stepper')[0])

            $(document).on('click', '.btn-next', function() {
                stepper.next();
            })

            $(document).on('click', '.btn-prev', function() {
                stepper.previous();
            })

            $(document).on('change', '#type_subject', function() {
                const selected_type = $('#type_subject').val();

                $('#subject_id').html('<option value="" selected>{{ __('course.select_subject') }}</option>');

                if (selected_type == "extracurricular") {
                    $('#levels_ids').selectpicker('deselectAll');
                    $('#sections_ids').selectpicker('deselectAll');
                    $('#levels_div').hide();
                    $('#sections_div').show();
                    $('#subject_name_div').show();

                    $.ajax({
                        url: '{{ url('api/v1/subject/get') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: {
                            type: 'extracurricular'
                        },
                        dataType: 'JSON',
                        //contentType: false,
                        //processData: false,
                        success: function(response) {

                            $.each(response.data, function() {
                                $("#subject_id").append(
                                    `<option value="${this.id}"> ${this.name} </option>`
                                );
                            });


                        },
                        error: function(data) {
                            var errors = data.responseJSON;
                            console.log(errors);
                        }


                    });

                } else {
                    $('#levels_ids').selectpicker('deselectAll');
                    $('#sections_ids').selectpicker('deselectAll');
                    $('#levels_div').show();
                    $('#sections_div').hide();
                    $('#subject_name_div').hide();
                }

                //stepper.next();
            })

            $(document).on('change', '#levels_ids', function() {

                const levels = $(this).val();

                $('#subject_id').html('<option value="" selected>{{ __('course.select_subject') }}</option>');

                if (levels.length) {
                    $.ajax({
                        url: '{{ url('api/v1/subject/get') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: {
                            levels: $(this).val(),
                            type: 'academic'
                        },
                        dataType: 'JSON',
                        //contentType: false,
                        //processData: false,
                        success: function(response) {

                            $.each(response.data, function() {
                                $("#subject_id").append(
                                    `<option value="${this.id}"> ${this.name} </option>`
                                );
                            });

                        },
                        error: function(data) {
                            var errors = data.responseJSON;
                            console.log(errors);
                        }


                    });
                }



            })

            $(document).on('change', '#subject_id', function() {

                const selected_type = $('#type_subject').val();

                if (selected_type == "extracurricular") {

                    if ($(this).val()) {
                        $('#subject_name_div').hide();
                    } else {
                        $('#subject_name_div').show();
                    }

                }

            })

            $('#course_submit_btn').on('click', function() {
                /* var queryString = new FormData($("#course_form")[0]);
                queryString.append('levels_ids' , $('#levels_ids').val());
                queryString.append('sections_ids' , $('#sections_ids').val()); */
                $.ajax({
                    url: '{{ route('user.courses.store') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                      name: $('#name').val(),
                      description: $('#description').val(),
                      price: $('#price').val(),
                      type_subject: $('#type_subject').val(),
                      name_subject: $('#name_subject').val(),
                      subject_id: $('#subject_id').val(),
                      levels_ids: $('#levels_ids').val(),
                      sections_ids: $('#sections_ids').val()
                    },
                    dataType: 'JSON',
                    //contentType: false,
                    //processData: false,
                    success: function(response) {
                        if (response.status == 1) {
                            $(this).prop('disabled', true);
                            $('#course_next_btn').prop('disabled', false);
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



        });
    </script>
@endsection
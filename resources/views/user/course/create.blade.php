@extends('layouts/contentNavbarLayout')

@section('vendor-script')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="{{ asset('assets/vendor/js/dropzone.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/js/stepper.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/dropzone.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/stepper.css') }}" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
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
            <h5>Default</h5>
        </div>

        <!-- Default Wizard -->
        <div class="col-12 mb-6">
            <small class="text-light fw-medium">Basic</small>
            <div class="bs-stepper wizard-numbered mt-2">
                <div class="bs-stepper-header">
                    <div class="step" data-target="#account-details">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Account Details</span>
                                <span class="bs-stepper-subtitle">Setup Account Details</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="bx bx-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#personal-info">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Personal Info</span>
                                <span class="bs-stepper-subtitle">Add personal info</span>
                            </span>

                        </button>
                    </div>
                    <div class="line">
                        <i class="bx bx-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#social-links">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">3</span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Social Links</span>
                                <span class="bs-stepper-subtitle">Add social links</span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <form onSubmit="return false">
                        <!-- Account Details -->
                        <div id="account-details" class="content">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Account Details</h6>
                                <small>Enter Your Account Details.</small>
                            </div>
                            <div class="row g-6">
                                <div class="col-sm-6">
                                    <label class="form-label" for="name">Course name</label>
                                    <input type="text" id="name" name="name" class="form-control" />
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="type_subject">Course type</label>
                                    <select class="form-select" id="type_subject" name="type_subject">
                                        <option value="academic">academic</option>
                                        <option value="extracurricular">extracurricular</option>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="price">Course price</label>
                                    <input type="number" id="price" name="price" class="form-control" />
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="description">Course description</label>
                                    <textarea name="description" id="description" class="form-control"></textarea>
                                </div>

                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-label-secondary btn-prev" disabled>
                                        <i class="bx bx-left-arrow-alt bx-sm ms-sm-n2 me-sm-2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-primary btn-next" id="next-1">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Personal Info -->
                        <div id="personal-info" class="content">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Personal Info</h6>
                                <small>Enter Your Personal Info.</small>
                            </div>
                            <div class="row g-6">
                                <div class="col-sm-6" id="levels_div">
                                    <label class="form-label" for="levels_ids">Levels</label>
                                    <select class="form-control selectpicker" id="levels_ids" name="levels_ids"
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
                                    <label class="form-label" for="sections_ids">Sections</label>
                                    <select class="form-control selectpicker" id="sections_ids" name="sections_ids"
                                        data-dropup-auto="false" multiple data-selected-text-format="count" multiple>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}">{{ $section->name(session('locale')) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6" id="subjects_div">
                                    <label class="form-label" for="subject_id">Subject</label>
                                    <select class="form-control selectpicker" id="subject_id" name="subject_id"
                                        data-dropup-auto="false">
                                    </select>
                                </div>
                                <div class="col-sm-6" id="subject_name_div">
                                    <label class="form-label" for="name_subject">Subject Name</label>
                                    <input class="form-control" id="name_subject" name="name_subject" type="text">
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev">
                                        <i class="bx bx-left-arrow-alt bx-sm ms-sm-n2 me-sm-2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-primary btn-next">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Social Links -->
                        <div id="social-links" class="content">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Social Links</h6>
                                <small>Enter Your Social Links.</small>
                            </div>
                            <div class="row g-6">
                                <div class="col-sm-6">
                                    <label class="form-label" for="twitter">Twitter</label>
                                    <input type="text" id="twitter" class="form-control"
                                        placeholder="https://twitter.com/abc" />
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="facebook">Facebook</label>
                                    <input type="text" id="facebook" class="form-control"
                                        placeholder="https://facebook.com/abc" />
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="google">Google+</label>
                                    <input type="text" id="google" class="form-control"
                                        placeholder="https://plus.google.com/abc" />
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="linkedin">LinkedIn</label>
                                    <input type="text" id="linkedin" class="form-control"
                                        placeholder="https://linkedin.com/abc" />
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev">
                                        <i class="bx bx-left-arrow-alt bx-sm ms-sm-n2 me-sm-2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-success btn-submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker();
            var stepper = new Stepper($('.bs-stepper')[0])

            /* $(document).on('click', '.btn-next', function() {
                stepper.next();
            }) */

            $(document).on('click', '.btn-prev', function() {
                stepper.previous();
            })

            $(document).on('click', '#next-1', function() {
                const selected_type = $('#type_subject').val();
                if (selected_type == "extracurricular") {
                    $('#levels_ids').selectpicker('deselectAll');
                    $('#sections_ids').selectpicker('deselectAll');
                    $('#levels_div').hide();
                    $('#sections_div').show();
                } else {
                    $('#levels_ids').selectpicker('deselectAll');
                    $('#sections_ids').selectpicker('deselectAll');
                    $('#levels_div').show();
                    $('#sections_div').hide();
                }

                stepper.next();
            })

            $(document).on('change', '#levels_ids', function() {
                //console.log($(this).val());
                const levels = $(this).val();

                $('#subject_id').html('');

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
                            console.log(response.data);


                            $.each(response.data, function() {
                              console.log(this.id);
                                $("#subject_id").append(`<option value="${this.id}"> ${this.name} </option>`);
                            });


                        },
                        error: function(data) {
                            var errors = data.responseJSON;
                            console.log(errors);
                        }


                    });
                }

                $('#subject_id').selectpicker('refresh');

            })


        });
    </script>
@endsection

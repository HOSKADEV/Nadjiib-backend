@extends('layouts/contentNavbarLayout')

@section('title', __('Settings'))

@section('vendor-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')

    <h4 class="fw-bold py-3 mb-3">
        <span class="text-muted fw-light"></span> {{ __('Version') }}
    </h4>

    <form class="form-horizontal" onsubmit="event.preventDefault()" action="#" enctype="multipart/form-data"
        id="version_form">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('Android') }}</h5>
                        <small class="text-muted float-end">{{ __('Android version') }}</small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="android_version_number">{{ __('Version number') }}</label>
                            <input type="text" class="form-control" id="android_version_number"
                                name="android_version_number" value="{{ $android->version_number }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="android_build_number">{{ __('Build number') }}</label>
                            <input type="text" class="form-control" id="android_build_number" name="android_build_number"
                                value="{{ $android->build_number }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="android_priority">{{ __('Priority') }}</label>
                            <select class="form-select" id="android_priority" name="android_priority">
                                <option value="0" @if ($android->priority == 0) selected @endif>
                                    {{ __('Optional') }}</option>
                                <option value="1" @if ($android->priority == 1) selected @endif>
                                    {{ __('Required') }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="android_link">{{ __('Link') }}</label>
                            <textarea class="form-control" id="android_link" name="android_link"> {{ $android->link }}</textarea>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('iOS') }}</h5>
                        <small class="text-muted float-end">{{ __('iOS version') }}</small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="ios_version_number">{{ __('Version number') }}</label>
                            <input type="text" class="form-control" id="ios_version_number" name="ios_version_number"
                                value="{{ $ios->version_number }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="ios_build_number">{{ __('Build number') }}</label>
                            <input type="text" class="form-control" id="ios_build_number" name="ios_build_number"
                                value="{{ $ios->build_number }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="ios_priority">{{ __('Priority') }}</label>
                            <select class="form-select" id="ios_priority" name="ios_priority">
                                <option value="0" @if ($ios->priority == 0) selected @endif>
                                    {{ __('Optional') }}</option>
                                <option value="1" @if ($ios->priority == 1) selected @endif>
                                    {{ __('Required') }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="ios_link">{{ __('Link') }}</label>
                            <textarea class="form-control" id="ios_link" name="ios_link">{{ $ios->link }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3" style="text-align: center">
                <button type="submit" id="submit_version" name="submit_version"
                    class="btn btn-primary">{{ __('Send') }}</button>
            </div>
        </div>

    </form>


    <h4 class="fw-bold py-3 mb-3">
        <span class="text-muted fw-light"></span> {{ __('Miscellaneous') }}
    </h4>

    <form class="form-horizontal" onsubmit="event.preventDefault()" action="#" enctype="multipart/form-data"
        id="misc_form">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('Tasks Thresholds') }}</h5>
                        <small class="text-muted float-end">{{ __('Tasks Thresholds') }}</small>
                    </div>
                    <div class="card-body">
                        <div class="row  justify-content-between">
                            <label class="form-label" for="name">{{ __('Calls Duration') }}</label>
                            <div class="form-group col-md-4 p-3">
                                <input type="number" class="form-control" id="duration_hours"
                                    value="{{ $duration_hours }}">
                                <label class="form-label" for="duration_hours">{{ __('Hours') }}</label>
                            </div>

                            <div class="form-group col-md-4 p-3">
                                <input type="number" class="form-control" id="duration_minutes"
                                    value="{{ $duration_minutes }}">
                                <label class="form-label" for="name">{{ __('Minutes') }}</label>
                            </div>

                            <div class="form-group col-md-4 p-3">
                                <input type="number" class="form-control" id="duration_seconds"
                                    value="{{ $duration_seconds }}">
                                <label class="form-label" for="name">{{ __('Seconds') }}</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="kilometre_price">{{ __('Number of Posts') }}</label>
                            <input type="number" class="form-control" id="posts_number" name="posts_number"
                                value="{{ $posts_number }}" />
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('Bonuses and discounts') }}</h5>
                        <small class="text-muted float-end">{{ __('Bonuses and discounts') }}</small>
                    </div>
                    <div class="card-body">

                        <div class="row  justify-content-between">

                            <div class="form-group col-md-6 p-3">
                                <label class="form-label" for="cloud_bonus">{{ __('Cloud bonus') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" class="form-control" id="cloud_bonus" name="cloud_bonus"
                                        value="{{ $cloud_bonus }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="form-group col-md-6 p-3">
                                <label class="form-label" for="community_bonus">{{ __('Community bonus') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" class="form-control" id="community_bonus"
                                        name="community_bonus" value="{{ $community_bonus }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <div class="row  justify-content-between" style="margin-top:10px">

                            <div class="form-group col-md-4 p-3">
                                <label class="form-label" for="standard_bonus">{{ __('Standard Percentages') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" class="form-control" id="standard_bonus" name="standard_bonus"
                                        value="{{ $standard_bonus }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="form-group col-md-4 p-3">
                                <label class="form-label" for="invitation_bonus">{{ __('Invitation bonus') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" class="form-control" id="invitation_bonus"
                                        name="invitation_bonus" value="{{ $invitation_bonus }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="form-group col-md-4 p-3">
                                <label class="form-label"
                                    for="invitation_discount">{{ __('Invitation discount') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" class="form-control" id="invitation_discount"
                                        name="invitation_discount" value="{{ $invitation_discount }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="mb-3" style="text-align: center">
                <button type="submit" id="submit_misc" name="submit_misc"
                    class="btn btn-primary">{{ __('Send') }}</button>
            </div>
        </div>

    </form>


    <h4 class="fw-bold py-3 mb-3">
        <span class="text-muted fw-light"></span> {{ __('Contact') }}
    </h4>

    <form class="form-horizontal" onsubmit="event.preventDefault()" action="#" enctype="multipart/form-data"
        id="contact_form">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="email">{{ __('Email') }}</label>
                            <input type="text" class="form-control" id="email" name="email"
                                value="{{ $email }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="whatsapp">{{ __('Whatsapp') }}</label>
                            <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                value="{{ $whatsapp }}" />
                        </div>


                    </div>
                </div>
            </div>


            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="facebook">{{ __('Facebook') }}</label>
                            <input type="text" class="form-control" id="facebook" name="facebook"
                                value="{{ $facebook }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="instagram">{{ __('Instagram') }}</label>
                            <input type="text" class="form-control" id="instagram" name="instagram"
                                value="{{ $instagram }}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3" style="text-align: center">
                <button type="submit" id="submit_contact" name="submit_contact"
                    class="btn btn-primary">{{ __('Send') }}</button>
            </div>
        </div>

    </form>

    <h4 class="fw-bold py-3 mb-3">
        <span class="text-muted fw-light"></span> {{ __('Financial') }}
    </h4>

    <form class="form-horizontal" onsubmit="event.preventDefault()" action="#" enctype="multipart/form-data"
        id="bank_form">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <div hidden=""><img src="{{ $form_image ?? asset('assets/img/icons/file-not-found.jpg') }}"
                                    alt="image" class="d-block rounded" height="190" width="190"
                                    id="old-image"> </div>
                            <img src="{{ $form_image ?? asset('assets/img/icons/file-not-found.jpg') }}" alt="image"
                                class="d-block rounded" height="190" width="190" id="uploaded-image">
                            <div class="button-wrapper">
                                <label for="image" class="btn btn-primary" tabindex="0">
                                    <span class="d-none d-sm-block">صورة جديدة</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input class="image-input" type="file" id="image" name="image"
                                        hidden="" accept="image/*">
                                </label>
                                <button type="button" class="btn btn-outline-secondary image-reset">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">استعادة</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="ccp">{{ __('CCP') }}</label>
                            <input type="text" class="form-control" id="ccp" name="ccp"
                                value="{{ $ccp }}" />
                        </div>
                        <br>
                        <div class="mb-3">
                            <label class="form-label" for="baridi_mob">{{ __('Baridi mob') }}</label>
                            <input type="text" class="form-control" id="baridi_mob" name="baridi_mob"
                                value="{{ $baridi_mob }}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3" style="text-align: center">
                <button type="submit" id="submit_bank" name="submit_bank"
                    class="btn btn-primary">{{ __('Send') }}</button>
            </div>
        </div>

    </form>

    {{--
      <h4 class="fw-bold py-3 mb-3">
        <span class="text-muted fw-light"></span> {{__('WhatsApp')}}
      </h4>

        <form class="form-horizontal" onsubmit="event.preventDefault()" action="#"
        enctype="multipart/form-data" id="whatsapp_form">
          <div class="row">
            <div class="col-xl">
              <div class="card mb-4">
                <div class="card-body">
                  <div class="mb-3">
                    <label class="form-label" for="kilometre_price">{{__('Whatsapp contact number')}}</label>
                    <div class="input-group input-group-merge">
                      <input type="text" class="form-control" id="country_code" name="country_code" value="+213" readonly style="padding: 10px 20px;"/>
                      <input type="text" class="form-control" id="number" name="number" value="{{$whatsapp}}" style="padding: 10px 20px;"/>
                    </div>
                  </div>

                </div>
              </div>
            </div>


            <div class="mb-3" style="text-align: center">
              <button type="submit" id="submit_whatsapp" name="submit_whatsapp" class="btn btn-primary">{{__('Send')}}</button>
            </div>
          </div>

        </form> --}}

@endsection

@section('page-script')
    <script>
        $(document).ready(function() {

            $('#submit_version').on('click', function() {
                var queryString = new FormData($("#version_form")[0]);
                //console.log(queryString);
                $.ajax({
                    url: '{{ url('dashboard/setting/version/update') }}',
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
                            Swal.fire(
                                "{{ __('Success') }}",
                                "{{ __('success') }}",
                                'success'
                            );
                        } else {
                            console.log(response.message);
                            Swal.fire(
                                "{{ __('Error') }}",
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                        Swal.fire(
                            "{{ __('Error') }}",
                            errors.message,
                            'error'
                        );
                        // Render the errors with js ...
                    }


                });

            });

            $('#submit_misc').on('click', function() {
                var queryString = new FormData($("#misc_form")[0]);

                var duration_hours = document.getElementById('duration_hours').value;
                var duration_minutes = document.getElementById('duration_minutes').value;
                var duration_seconds = document.getElementById('duration_seconds').value;

                var duration_hours = parseInt(duration_hours) ? parseInt(duration_hours) : 0;
                var duration_minutes = parseInt(duration_minutes) ? parseInt(duration_minutes) : 0;
                var duration_seconds = parseInt(duration_seconds) ? parseInt(duration_seconds) : 0;

                var calls_duration = duration_hours * 3600 + duration_minutes * 60 + duration_seconds;

                console.log(calls_duration);

                queryString.append('calls_duration', calls_duration);
                //console.log(queryString);
                $.ajax({
                    url: '{{ url('dashboard/setting/misc/update') }}',
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
                            Swal.fire(
                                "{{ __('Success') }}",
                                "{{ __('success') }}",
                                'success'
                            );
                        } else {
                            console.log(response.message);
                            Swal.fire(
                                "{{ __('Error') }}",
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                        Swal.fire(
                            "{{ __('Error') }}",
                            errors.message,
                            'error'
                        );
                        // Render the errors with js ...
                    }


                });

            });

            $('#submit_contact').on('click', function() {
                var queryString = new FormData($("#contact_form")[0]);
                //console.log(queryString);
                $.ajax({
                    url: '{{ url('dashboard/setting/contact/update') }}',
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
                            Swal.fire(
                                "{{ __('Success') }}",
                                "{{ __('success') }}",
                                'success'
                            );
                        } else {
                            console.log(response.message);
                            Swal.fire(
                                "{{ __('Error') }}",
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                        Swal.fire(
                            "{{ __('Error') }}",
                            errors.message,
                            'error'
                        );
                        // Render the errors with js ...
                    }


                });

            });

            $('#submit_bank').on('click', function() {
                var queryString = new FormData($("#bank_form")[0]);
                //console.log(queryString);
                $.ajax({
                    url: '{{ url('dashboard/setting/bank/update') }}',
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
                            Swal.fire(
                                "{{ __('Success') }}",
                                "{{ __('success') }}",
                                'success'
                            );
                        } else {
                            console.log(response.message);
                            Swal.fire(
                                "{{ __('Error') }}",
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                        Swal.fire(
                            "{{ __('Error') }}",
                            errors.message,
                            'error'
                        );
                        // Render the errors with js ...
                    }


                });

            });
        });

        $('.image-input').on('change', function(event) {
            const id = $(this).attr('id').replace('image', '');
            //const fileInput = document.querySelector('.image-input');
            const fileInput = document.getElementById('image' + id);
            if (fileInput.files[0]) {
                document.getElementById('uploaded-image' + id).src = window.URL.createObjectURL(fileInput
                    .files[0]);
            }
        });
        $('.image-reset').on('click', function(event) {
            const id = $(this).attr('id').replace('reset', '');
            //const fileInput = document.querySelector('.image-input');
            const fileInput = document.getElementById('image' + id);
            fileInput.value = '';
            document.getElementById('uploaded-image' + id).src = document.getElementById('old-image' + id).src;
        });
    </script>
@endsection

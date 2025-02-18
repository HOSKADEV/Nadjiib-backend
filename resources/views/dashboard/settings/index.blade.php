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

    <form class="form-horizontal" onsubmit="event.preventDefault()" action="#" enctype="multipart/form-data"
    id="form">

    <h4 class="fw-bold py-3 mb-3">
        <span class="text-muted fw-light"></span> {{ __('Miscellaneous') }}
    </h4>

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
                                value="{{ $settings['posts_number'] ?? '' }}" />
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
                                        value="{{ $settings['cloud_bonus'] ?? '' }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="form-group col-md-6 p-3">
                                <label class="form-label" for="community_bonus">{{ __('Community bonus') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" class="form-control" id="community_bonus"
                                        name="community_bonus" value="{{ $settings['community_bonus'] ?? '' }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <div class="row  justify-content-between mt-4 mb-3">

                            <div class="form-group col-md-4">
                                <label class="form-label" for="standard_bonus">{{ __('Standard Percentages') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" class="form-control" id="standard_bonus" name="standard_bonus"
                                        value="{{ $settings['standard_bonus'] ?? '' }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="form-label" for="invitation_bonus">{{ __('Invitation bonus') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" class="form-control" id="invitation_bonus"
                                        name="invitation_bonus" value="{{ $settings['invitation_bonus'] ?? '' }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="form-label"
                                    for="invitation_discount">{{ __('Invitation discount') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" class="form-control" id="invitation_discount"
                                        name="invitation_discount" value="{{ $settings['invitation_discount'] ?? '' }}">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>




    <h4 class="fw-bold py-3 mb-3">
        <span class="text-muted fw-light"></span> {{ __('Contact') }}
    </h4>


        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="email">{{ __('Email') }}</label>
                            <input type="text" class="form-control" id="email" name="email"
                                value="{{ $settings['email'] ?? '' }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="whatsapp">{{ __('Whatsapp') }}</label>
                            <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                value="{{ $settings['whatsapp'] ?? '' }}" />
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
                                value="{{ $settings['facebook'] ?? '' }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="instagram">{{ __('Instagram') }}</label>
                            <input type="text" class="form-control" id="instagram" name="instagram"
                                value="{{ $settings['instagram'] ?? '' }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>



    <h4 class="fw-bold py-3 mb-3">
        <span class="text-muted fw-light"></span> {{ __('Financial') }}
    </h4>


        <div class="row">
            <div class="col-xl">
                <div class="row mb-4">
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">CCP & Baridimob Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl">
                                        <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                                            <div hidden="">
                                                <img src="{{ $form_image ?? asset('assets/img/icons/file-not-found.jpg') }}"
                                                    alt="image" class="d-block rounded" height="170" width="170"
                                                    id="old-image">
                                            </div>
                                            <img src="{{ $form_image ?? asset('assets/img/icons/file-not-found.jpg') }}"
                                                alt="image" class="d-block rounded" height="170" width="170"
                                                id="uploaded-image">
                                            <div class="button-wrapper">
                                                <label for="image" class="btn btn-primary" tabindex="0">
                                                    <span class="d-none d-sm-block">صورة جديدة</span>
                                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                                    <input class="image-input" type="file" id="image"
                                                        name="image" hidden="" accept="image/*">
                                                </label>
                                                <button type="button" class="btn btn-outline-secondary image-reset">
                                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">استعادة</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl">
                                        <div class="mb-3">
                                            <label class="form-label" for="ccp">{{ __('CCP') }}</label>
                                            <input type="text" class="form-control" id="ccp" name="ccp"
                                                value="{{ $settings['ccp'] ?? '' }}" />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label d-block">Platforms</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="hidden" name="ccp_android"
                                                    value="0">
                                                <input class="form-check-input" type="checkbox" name="ccp_android"
                                                    id="ccp_android" value="1"
                                                    @if ($settings['ccp_android'] ?? false) checked @endif>
                                                <label class="form-check-label" for="ccp_android">Android</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="hidden" name="ccp_ios"
                                                    value="0">
                                                <input class="form-check-input" type="checkbox" name="ccp_ios"
                                                    id="ccp_ios" value="1"
                                                    @if ($settings['ccp_ios'] ?? false) checked @endif>
                                                <label class="form-check-label" for="ccp_ios">iOS</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl">

                                        <div class="mb-3">
                                            <label class="form-label" for="baridi_mob">{{ __('Baridi mob') }}</label>
                                            <input type="text" class="form-control" id="baridi_mob" name="baridi_mob"
                                                value="{{ $settings['baridi_mob'] ?? '' }}" />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label d-block">Platforms</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="hidden" name="baridimob_android"
                                                    value="0">
                                                <input class="form-check-input" type="checkbox" name="baridimob_android"
                                                    id="baridimob_android" value="1"
                                                    @if ($settings['baridimob_android'] ?? false) checked @endif>
                                                <label class="form-check-label" for="baridimob_android">Android</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="hidden" name="baridimob_ios"
                                                    value="0">
                                                <input class="form-check-input" type="checkbox" name="baridimob_ios"
                                                    id="baridimob_ios" value="1"
                                                    @if ($settings['baridimob_ios'] ?? false) checked @endif>
                                                <label class="form-check-label" for="baridimob_ios">iOS</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl">
                <div class="row mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Chargily Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="form-label" for="chargily_pk">Public Key</label>
                                <input type="text" class="form-control" id="chargily_pk" name="chargily_pk"
                                    value="{{ $settings['chargily_pk'] ?? '' }}" />
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="chargily_sk">Secret Key</label>
                                <input type="text" class="form-control" id="chargily_sk" name="chargily_sk"
                                    value="{{ $settings['chargily_sk'] ?? '' }}" />
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="chargily_mode">Mode</label>
                                <select class="form-select" id="chargily_mode" name="chargily_mode">
                                    <option value="test" @if (($settings['chargily_mode'] ?? '') === 'test') selected @endif>Test</option>
                                    <option value="live" @if (($settings['chargily_mode'] ?? '') === 'live') selected @endif>Live</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-block">Platforms</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="hidden" name="chargily_android"
                                        value="0">
                                    <input class="form-check-input" type="checkbox" name="chargily_android"
                                        id="chargily_android" value="1"
                                        @if ($settings['chargily_android'] ?? false) checked @endif>
                                    <label class="form-check-label" for="chargily_android">Android</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="hidden" name="chargily_ios" value="0">
                                    <input class="form-check-input" type="checkbox" name="chargily_ios"
                                        id="chargily_ios" value="1"
                                        @if ($settings['chargily_ios'] ?? false) checked @endif>
                                    <label class="form-check-label" for="chargily_ios">iOS</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="fw-bold py-3 mb-3">
          <span class="text-muted fw-light"></span> {{ __('Alerts Settings') }}
      </h4>
      <div class="card mb-4">
          <div class="card-body">
              <div class="row mb-3">
                  <div class="col-md-6">
                      <label class="form-label" for="pusher_instance_id">{{ __('Pusher Instance ID') }}</label>
                      <input type="text" class="form-control" id="pusher_instance_id" name="pusher_instance_id"
                          value="{{ $settings['pusher_instance_id'] ?? '' }}">
                  </div>
                  <div class="col-md-6">
                      <label class="form-label" for="pusher_primary_key">{{ __('Pusher Primary Key') }}</label>
                      <input type="password" class="form-control" id="pusher_primary_key" name="pusher_primary_key"
                          value="{{ $settings['pusher_primary_key'] ?? '' }}">
                  </div>
              </div>
          </div>
      </div>

        <div class="row">
            <div class="col-12" style="text-align: center">
                <button type="submit" id="submit_setting" name="submit_setting"
                    class="btn btn-primary">{{ __('Send') }}</button>
            </div>
        </div>

    </form>


@endsection

@section('page-script')
    <script>
        $(document).ready(function() {

            $('#submit_version').on('click', function() {
                var queryString = new FormData($("#version_form")[0]);
                //console.log(queryString);
                $.ajax({
                    url: '{{ url('dashboard/version/update') }}',
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

            $('#submit_setting').on('click', function() {
                var queryString = new FormData($("#form")[0]);

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
                    url: '{{ url('dashboard/setting/update') }}',
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

@extends('layouts/contentNavbarLayout')

@section('title', trans('app_setting.app_settings'))

@section('vendor-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.js"></script>
@endsection

@section('vendor-style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css" rel="stylesheet"/>
    <style>
        .hiddenRow {
            padding: 0 !important;
        }
    </style>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('app_setting.app_settings') }}
    </h4>
@endsection

@section('content')
    {{-- Include the create modal for app settings --}}
    @include('dashboard.appsetting.create')

    <div class="card">
        <h5 class="card-header pt-0 mt-1">
            <form action="" method="GET" id="searchAppSettingForm">
                <div class="row justify-content-between">
                    <div class="form-group col-md-4 mr-5 mt-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#appSettingModal">
                            <span class="tf-icons bx bx-plus"></span>&nbsp; {{ trans('app_setting.create') }}
                        </button>
                    </div>
                    <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="key_filter" class="form-label">{{ trans('app_setting.key') }}</label>
                        <input type="text" id="key_filter" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-solid"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('app_setting.placeholder.key') }}">
                    </div>
                </div>
            </form>
        </h5>

        <div class="table-responsive text-nowrap">
            <table class="table table-condensed" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="width:10%;">#</th>
                        <th style="width:40%;">{{ trans('app_setting.key') }}</th>
                        <th style="width:40%;">{{ trans('app_setting.value') }}</th>
                        <th style="width:10%;">{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appSettings as $setting)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $setting->key }}</td>
                            <td>
                                @php
                                    $decoded = json_decode($setting->value, true);
                                @endphp
                                @if (is_bool($decoded))
                                    {{ $decoded ? 'true' : 'false' }}
                                @elseif(is_array($decoded))
                                    {{-- if the values preserve numeric indexes then treat it as a simple array --}}
                                    @if (array_values($decoded) === $decoded)
                                        {{ implode(', ', $decoded) }}
                                    @else
                                        @foreach ($decoded as $k => $v)
                                            <strong>{{ $k }}</strong>: {{ $v }} <br>
                                        @endforeach
                                    @endif
                                @else
                                    {{ $decoded }}
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info mx-1" data-bs-toggle="modal" data-bs-target="#editAppSettingModal{{ $setting->id }}">
                                    <i class='bx bxs-edit'></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#deleteAppSettingModal{{ $setting->id }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                        {{-- Include modals for editing and deleting --}}
                        {{-- @include('dashboard.appsetting.edit-edit', ['setting' => $setting]) --}}
                        {{-- @include('dashboard..delete', ['setting' => $setting]) --}}
                    @endforeach
                </tbody>
            </table>

            {{-- {{ $appSettings->links() }} --}}
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            function submitForm(){
                $("#searchAppSettingForm").submit();
            }
            $('#key_filter').on('keyup', function(){
                // Focus on input and give a delay before submitting
                timer = setTimeout(function(){
                    submitForm();
                }, 1000);
            });
        });
    </script>
@endsection

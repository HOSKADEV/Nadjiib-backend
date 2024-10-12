@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
@endsection

@section('vendor-script')
    <script src="{{ $users_chart->cdn() }}"></script>
    {{ $users_chart->script() }}
    {{ $purchases_chart->script() }}
    {{ $users_status_chart->script() }}
    {{ $courses_status_chart->script() }}
    {{ $purchases_status_chart->script() }}
@endsection

@section('page-style')
    <style>
        .h-50 {
            height: 50px;
        }
    </style>
@endsection

@section('content')
    <form id="form" method="GET" action="{{ route('dashboard') }}">
        <div class="row">

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-title mx-3 mt-3">
                        <div class="row  justify-content-between">
                            <div class="form-group col-8" style="display: flex;align-items: center;">
                                <h5 class="my-auto">{{ __('Users chart') }}</h5>
                            </div>
                            <div class="form-group col-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                                <select class="form-select" id="users_chart" name="users_chart">
                                    <option value="daily">{{ __('Last 7 days') }}</option>
                                    <option value="monthly"
                                        {{ Request::get('users_chart') == 'monthly' ? 'selected' : '' }}>
                                        {{ __('Last 6 months') }}</option>
                                    <option value="yearly" {{ Request::get('users_chart') == 'yearly' ? 'selected' : '' }}>
                                        {{ __('Last 5 years') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ $users_chart->container() }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-title mx-3 mt-3">
                        <div class="row  justify-content-between">
                            <div class="form-group col-8" style="display: flex;align-items: center;">
                                <h5 class="my-auto">{{ __('Purchases chart') }}</h5>
                            </div>
                            <div class="form-group col-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                                <select class="form-select" id="purchases_chart" name="purchases_chart">
                                    <option value="daily">{{ __('Last 7 days') }}</option>
                                    <option value="monthly"
                                        {{ Request::get('purchases_chart') == 'monthly' ? 'selected' : '' }}>
                                        {{ __('Last 6 months') }}</option>
                                    <option value="yearly"
                                        {{ Request::get('purchases_chart') == 'yearly' ? 'selected' : '' }}>
                                        {{ __('Last 5 years') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ $purchases_chart->container() }}
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
              <div class="card" style="height: 100%">
                    <div class="card-title mx-3 mt-3">

                        <div class="form-group" style="display: flex;align-items: center;">
                            <h5 class="my-auto">{{ __('Users roles') }}</h5>
                        </div>

                    </div>
                    <div class="card-body">
                        {{ $users_status_chart->container() }}
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card" style="height: 100%">
                    <div class="card-title mx-3 mt-3">

                        <div class="form-group" style="display: flex;align-items: center;">
                            <h5 class="my-auto">{{ __('Courses status') }}</h5>
                        </div>

                    </div>
                    <div class="card-body">
                        {{ $courses_status_chart->container() }}
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
              <div class="card" style="height: 100%">
                    <div class="card-title mx-3 mt-3">

                        <div class="form-group" style="display: flex;align-items: center;">
                            <h5 class="my-auto">{{ __('Purchases status') }}</h5>
                        </div>

                    </div>
                    <div class="card-body">
                        {{ $purchases_status_chart->container() }}
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            function submitForm() {
                $("#form").submit();
            }
            $('#users_chart').on('change', function() {
                timer = setTimeout(function() {
                    submitForm();
                }, 1000);
            });

            $('#purchases_chart').on('change', function() {
                timer = setTimeout(function() {
                    submitForm();
                }, 1000);
            });
        });
    </script>
@endsection

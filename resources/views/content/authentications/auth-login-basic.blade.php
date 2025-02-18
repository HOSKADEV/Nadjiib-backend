@extends('layouts/blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/dashboard')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])</span>
              <span class="app-brand-text demo text-body fw-bolder">{{ config('app.locale') == 'en' ? "Najiib" : "نجيب"  }}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">{{trans('app.welcome_to')}} {{ config('app.locale') == 'en' ? "Najiib" : "نجيب"  }}! 👋</h4>

          <form id="formAuthentication" class="mb-3" action="{{url('/auth/login-action')}}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">{{trans('app.email')}}</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="{{trans('app.enter_email')}}" autofocus>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">{{trans('app.password')}}</label>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">{{trans('app.sign_in')}}</button>
            </div>
          </form>

          <div class="divider my-4">
            <div class="divider-text">{{trans('app.or')}}</div>
          </div>

          <div class="mb-3">
            <a href="{{ route('google.redirect') }}" class="btn btn-outline-primary w-100">
              <i class="bx bxl-google me-2"></i> {{trans('app.sign_in_with_google')}}
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

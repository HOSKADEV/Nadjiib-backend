@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('page-style')
    <style>
        .app-academy .app-academy-img-height {
            height: 200px
        }

        @media(min-width: 768px) {
            .app-academy .app-academy-md-25 {
                width: 25%
            }

            .app-academy .app-academy-md-50 {
                width: 50%
            }

            .app-academy .app-academy-md-80 {
                width: 80%
            }
        }

        @media(min-width: 576px) {
            .app-academy .app-academy-sm-40 {
                width: 40% !important
            }

            .app-academy .app-academy-sm-60 {
                width: 60% !important
            }
        }

        @media(min-width: 1200px) {
            .app-academy .app-academy-xl-100 {
                width: 100% !important
            }

            .app-academy .app-academy-xl-100 {
                width: 100% !important
            }
        }
    </style>
@endsection

<div class="content-wrapper">

@section('content')
<div class="app-academy">
  <div class="card p-0 mb-6">
      <div class="card-body d-flex flex-column flex-md-row justify-content-between p-0 pt-6">
          <div class="app-academy-md-25 card-body py-0 pt-6 ps-12">
              <img src="../../assets/img/illustrations/Online learning-amico.png"
                  class="img-fluid app-academy-img-height scaleX-n1-rtl" {{-- alt="Bulb in hand"
                  data-app-light-img="illustrations/bulb-light.png"
                  data-app-dark-img="illustrations/bulb-dark.png" --}} height="100%" />
          </div>
          <div
              class="app-academy-md-50 card-body d-flex align-items-md-center flex-column text-md-center mb-6 py-6">
              <span class="card-title mb-4 px-md-12 h4">
                  <span class="text-primary text-nowrap">{{ trans('dashboard.user_welcome') }}</span>
              </span>
              <p class="mb-4">
                {{ trans('dashboard.user_dashboard_explanation') }}
              </p>
              {{-- <div class="d-flex align-items-center justify-content-between app-academy-md-80">
                  <input type="search" placeholder="Find your course" class="form-control me-4" />
                  <button type="submit" class="btn btn-primary btn-icon"><i
                          class="bx bx-search bx-md"></i></button>
              </div> --}}
          </div>
          <div class="app-academy-md-25 d-flex align-items-end justify-content-end">
              <img src="../../assets/img/illustrations/pencil-rocket.png" alt="pencil rocket" height="180"
                  class="scaleX-n1-rtl" />
          </div>
      </div>
  </div>
</div>
<br>
<div class="row gy-6 mb-6">
  <div class="col-lg-6">
    <div class="card shadow-none bg-label-primary h-100">
      <div class="card-body d-flex justify-content-between flex-wrap-reverse">
        <div class="mb-0 w-100 app-academy-sm-60 d-flex flex-column justify-content-between text-center text-sm-start">
          <div class="card-title">
            <h5 class="text-primary mb-2">{{ trans('dashboard.user_posts_section_title') }}</h5>
            <p class="text-body w-sm-80 app-academy-xl-100">
              {{ trans('dashboard.user_posts_management') }}
            </p>
          </div>
          <div class="mb-0"><a href="{{route('user.posts.index')}}" class="btn btn-sm btn-primary">{{ trans('dashboard.user_posts_button') }}</a></div>
        </div>
        <div class="w-100 app-academy-sm-40 d-flex justify-content-center justify-content-sm-end h-px-150 mb-4 mb-sm-0">
          <img class="img-fluid scaleX-n1-rtl" src="../../assets/img/illustrations/boy-app-academy.png" alt="boy illustration" />
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card shadow-none bg-label-danger h-100">
      <div class="card-body d-flex justify-content-between flex-wrap-reverse">
        <div class="mb-0 w-100 app-academy-sm-60 d-flex flex-column justify-content-between text-center text-sm-start">
          <div class="card-title">
            <h5 class="text-danger mb-2">{{ trans('dashboard.user_courses_section_title') }}</h5>
            <p class="text-body app-academy-sm-60 app-academy-xl-100">
              {{ trans('dashboard.user_courses_management') }}
            </p>
          </div>
          <div class="mb-0"><a href="{{route('user.courses.index')}}" class="btn btn-sm btn-danger">{{ trans('dashboard.user_courses_button') }}</a></div>
        </div>
        <div class="w-100 app-academy-sm-40 d-flex justify-content-center justify-content-sm-end h-px-150 mb-4 mb-sm-0">
          <img class="img-fluid scaleX-n1-rtl" src="../../assets/img/illustrations/girl-app-academy.png" alt="girl illustration" />
        </div>
      </div>
    </div>
  </div>
</div>
</div>

@endsection

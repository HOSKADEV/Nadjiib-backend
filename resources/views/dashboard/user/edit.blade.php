@extends('layouts/contentNavbarLayout')

@section('title', trans('user.edit'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('user.users') }}
    </h4>
@endsection

@section('content')
    <div class="card">
        <h5 class="card-header pt-1 mt-1">{{ trans('user.edit') }}</h5>
        <div class="card-body">
            <form method="post" action="{{ route('dashboard.users.update', 'test') }}">
                @method('PUT')
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="row">
                    <div class="col-sm-12 col-md-4 mb-2">
                        <label for="name" class="form-label">{{ trans('user.label.name') }}</label>
                        <input type="text" disabled value="{{ $user->name }}" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-4 mb-2">
                        <label for="email" class="form-label">{{ trans('user.label.email') }}</label>
                        <input type="text" disabled value="{{ $user->email }}" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-4 mb-2">
                        <label for="phone" class="form-label">{{ trans('user.label.phone') }}</label>
                        <input type="text" disabled value="{{ $user->phone }}" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label for="gender" class="form-label">{{ trans('user.label.gender') }}</label>
                        <input class="form-control" value="{{ trans('app.gender.'.$user->gender) }}" disabled>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <label for="cpp" class="form-label">{{ trans('user.label.ccp') }}</label>
                        <input type="text" id="ccp" name="ccp" value="{{ $user->ccp }}" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label for="baridi_mob" class="form-label">{{ trans('user.label.baridi_mob') }}</label>
                        <input type="text" id="baridi_mob" name="baridi_mob" value="{{ $user->baridi_mob }}" class="form-control">
                    </div>


                    <div class="col-sm-12 mt-3 d-flex">
                        <div class="col d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">{{ trans('app.update') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

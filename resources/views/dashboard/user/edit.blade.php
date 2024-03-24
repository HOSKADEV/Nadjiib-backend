@extends('layouts/contentNavbarLayout')

@section('title', trans('user.edit'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
    @endsectionv

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
                        <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control"
                            placeholder="{{ trans('user.placeholder.name') }}">
                    </div>
                    <div class="col-sm-12 col-md-4 mb-2">
                        <label for="email" class="form-label">{{ trans('user.label.email') }}</label>
                        <input type="text" id="email" name="email" value="{{ $user->email }}"
                            class="form-control" placeholder="{{ trans('user.placeholder.email') }}">
                    </div>
                    <div class="col-sm-12 col-md-4 mb-2">
                        <label for="phone" class="form-label">{{ trans('user.label.phone') }}</label>
                        <input type="text" id="phone" name="phone" value="{{ $user->phone }}"
                            class="form-control" placeholder="{{ trans('user.placeholder.phone') }}">
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label for="gender" class="form-label">{{ trans('user.label.gender') }}</label>
                        <select class="form-select @error('gender') is-invalid @enderror" name="gender">
                            <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>
                                {{ trans('app.gender.male') }}
                            </option>
                            <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>
                                {{ trans('app.gender.female') }}
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label for="status" class="form-label">{{ trans('user.label.status') }}</label>
                        <input type="text" id="phone" name="phone" value="{{ $user->phone }}"
                            class="form-control" placeholder="{{ trans('user.placeholder.phone') }}">
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label for="password" class="form-label">{{ trans('user.label.password') }}</label>
                        <input type="text" id="password" name="password" class="form-control">
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

@section('scripts')

@endsection

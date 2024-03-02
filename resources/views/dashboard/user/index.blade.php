@extends('layouts/contentNavbarLayout')

@section('title', trans('user.users'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
    @endsectionv

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('user.users') }}
    </h4>
@endsection

@section('content')
    {{-- @include('dashboard.coupon.create') --}}
    <div class="card">
        <h5 class="card-header pt-1 mt-1">
            <form action="" method="GET" id="searchUserForm">
                <div class="row">
                    <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="name" class="form-label">{{ trans('user.label.status') }}</label>
                        <select class="form-select" id="status" name="status" aria-label="Default select example">
                            <option value="{{ Request::get('status') != '' ? Request::get('status') : '' }}"
                                {{ Request::get('status') != '' ? 'selected' : '' }}>
                                {{ Request::get('status') != '' ? (Request::get('status') == 1 ? trans('user.statuss.active') : trans('user.statuss.inactive')) : trans('user.select.status') }}
                            </option>
                            <option value="1">{{ trans('user.statuss.active') }}</option>
                            <option value="2">{{ trans('user.statuss.inactive') }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="role" class="form-label">{{ trans('user.label.role') }}</label>
                        <select class="form-select" id="role" name="role" aria-label="Default select example">
                            <option value="{{ Request::get('role') != '' ? Request::get('role') : '' }}"
                                {{ Request::get('role') != '' ? 'selected' : '' }}>
                                {{ Request::get('role') != '' ? (Request::get('role') == 1 ? trans('user.statuss.active') : trans('user.statuss.inactive')) : trans('user.select.role') }}
                            </option>
                            <option value="1">{{ trans('user.statuss.active') }}</option>
                            <option value="2">{{ trans('user.statuss.inactive') }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="search" class="form-label">{{ trans('user.label.search') }}</label>
                        <input type="text" id="search" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-solid"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('user.placeholder.search') }}">
                    </div>
                </div>
            </form>

        </h5>
        <div class="table-responsive text-nowrap">

            <table class="table mb-2">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>{{ trans('user.name') }}</th>
                        <th>{{ trans('user.email') }}</th>
                        <th>{{ trans('user.phone') }}</th>
                        <th>{{ trans('user.role') }}</th>
                        <th>{{ trans('user.status') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->status }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info mx-1" data-bs-toggle="modal"
                                    data-bs-target="#editCouponModal{{ $user->id }}">
                                    <i class='bx bxs-edit'></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger mx-1" data-bs-toggle="modal"
                                    data-bs-target="#deleteCouponModal{{ $user->id }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                        {{-- @include('dashboard.coupon.edit') --}}
                        {{-- @include('dashboard.coupon.delete') --}}
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#status').on('change', function(event) {
                // $("#name").focus();

                timer = setTimeout(function() {
                    submitForm();
                }, 4000);

                function submitForm() {
                    $("#searchUserForm").submit();
                }
            });
        });
    </script>
@endsection

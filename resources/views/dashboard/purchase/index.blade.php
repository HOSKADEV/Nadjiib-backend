@extends('layouts/contentNavbarLayout')

@section('title', trans('user.users'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('payment.payments') }}
    </h4>
@endsection

@section('content')
    {{-- @include('dashboard.coupon.create') --}}
    <div class="card">
        <h5 class="card-header pt-1 mt-1">
            <form action="" method="GET" id="searchPurchaseForm">
                <div class="row">
                    <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="name" class="form-label">{{ trans('purchase.label.status') }}</label>
                        <select class="form-select" id="status" name="status" aria-label="Default select example">
                            <option value="">{{ trans('app.all') }}</option>
                            <option value="PENDING" {{ Request::get('status') == 'PENDING' ? 'selected' : '' }}>
                                {{ trans('app.status.Pending') }}</option>
                            <option value="FAILED" {{ Request::get('status') == 'FAILED' ? 'selected' : '' }}>
                                {{ trans('app.status.Failed') }}</option>
                            <option value="SUCCESS" {{ Request::get('status') == 'SUCCESS' ? 'selected' : '' }}>
                                {{ trans('app.status.Success') }}</option>
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
                        <th>{{ trans('purchase.student_name') }}</th>
                        <th>{{ trans('purchase.course_name') }}</th>
                        <th>{{ trans('purchase.price') }}</th>
                        <th>{{ trans('purchase.total') }}</th>
                        <th>{{ trans('purchase.status') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($purchases as $key => $purchase)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $purchase->student->user->name }}</td>
                            <td>{{ $purchase->course->name }}</td>
                            <td>{{ $purchase->price }}</td>
                            <td>{{ $purchase->total }}</td>
                            <td>
                                @switch($purchase->status)
                                    @case('PENDING')
                                        <span class="badge rounded-pill text-capitalize bg-warning">
                                            {{ trans('app.status.Pending') }}
                                        </span>
                                    @break

                                    @case('FAILED')
                                        <span class="badge rounded-pill text-capitalize bg-danger">
                                            {{ trans('app.status.Failed') }}
                                        </span>
                                    @break

                                    @case('SUCCESS')
                                        <span class="badge rounded-pill text-capitalize bg-success">
                                            {{ trans('app.status.Success') }}
                                        </span>
                                    @break

                                    @default
                                @endswitch
                                {{-- @if ($purchase->status == 'PENDING')
                                    <span class="badge rounded-pill text-capitalize bg-warning">
                                        {{ trans('app.status.Pending') }}
                                    </span>
                                @elseif ($purchase->status == 'FAILED')
                                    <span class="badge rounded-pill text-capitalize bg-danger">
                                        {{ trans('app.status.Failed') }}
                                    </span>
                                @else
                                    <span class="badge rounded-pill text-capitalize bg-success' ">
                                        {{ trans('app.status.Success') }}
                                    </span>
                                @endif --}}
                            </td>
                            {{-- 'PENDING','FAILED','SUCCESS' --}}

                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        {{-- <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#UpdateStatusModal{{ $user->id }}">
                                                <i class='bx bx-repeat me-2'></i>
                                                {{ $user->status == 'ACTIVE' ? trans('user.statuses.inactive') : trans('user.statuses.active') }}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('dashboard.users.edit', $user->id) }}">
                                                <i class='bx bxs-edit me-2'></i>
                                                {{ trans('user.edit') }}
                                            </a> --}}

                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                            data-bs-target="#deletePurchaseModal{{ $purchase->id }}">
                                            <i class="bx bx-trash me-2"></i>
                                            {{ trans('purchase.delete') }}
                                        </a>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        {{-- <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                {{ $user->account }}
                            </td>
                            <td>
                                <span
                                    class="badge rounded-pill text-capitalize bg-{{ $user->status == 'ACTIVE' ? 'success' : 'danger' }}">
                                    {{ $user->status == 'ACTIVE' ? trans('app.status.Active') : trans('app.status.Inactive') }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                            data-bs-target="#UpdateStatusModal{{ $user->id }}">
                                            <i class='bx bx-repeat me-2'></i>
                                            {{ $user->status == 'ACTIVE' ? trans('user.statuses.inactive') : trans('user.statuses.active') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('dashboard.users.edit', $user->id) }}">
                                            <i class='bx bxs-edit me-2'></i>
                                            {{ trans('user.edit') }}
                                        </a>
                                        @if ($user->teacher == null)
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#upgradeAccountModal{{ $user->id }}">
                                                <i class='bx bx-diamond me-2'></i>
                                                {{ trans('user.upgrade') }}
                                            </a>
                                        @endif

                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                            data-bs-target="#deleteUserModal{{ $user->id }}">
                                            <i class="bx bx-trash me-2"></i>
                                            {{ trans('user.delete') }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr> --}}
                        {{-- @include('dashboard.user.upgrade')
                        @include('dashboard.user.update-status')
                        @include('dashboard.user.delete') --}}
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-danger">
                                    {{ trans('purchase.no_purchase') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $purchases->links() }}
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
                    }, 1000);

                });

                // search
                $('#search').on('keyup', function(event) {
                    $("#search").focus();
                    timer = setTimeout(function() {
                        submitForm();
                    }, 4000);

                })

                function submitForm() {
                    $("#searchPurchaseForm").submit();
                }
            });
        </script>

    @endsection

@extends('layouts/contentNavbarLayout')

@section('title', trans('user.users'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
    <script src="https://unpkg.com/htmx.org@2.0.0" integrity="sha384-wS5l5IKJBvK6sPTKa2WZ1js3d947pvWXbPJ1OmWfEuxLgeHcEbjUUA5i9V5ZkpCw" crossorigin="anonymous"></script>
@endsection

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
                            {{-- <option value="{{ Request::get('status') != '' ? Request::get('status') : '' }}"
                                {{ Request::get('status') != '' ? 'selected' : '' }}>
                                {{ Request::get('status') != '' ? (Request::get('status') == 'ACTIVE' ? trans('user.statuss.active') : trans('user.statuss.inactive')) : trans('user.select.status') }} --}}
                            </option>
                            <option value="" {{ Request::get('status') == '' ? 'selected' : '' }}>{{ trans('app.all') }}</option>
                            <option value="ACTIVE" {{ Request::get('status') == 'ACTIVE' ? 'selected' : '' }}>{{ trans('user.statuss.active') }}</option>
                            <option value="INACTIVE" {{ Request::get('status') == 'INACTIVE' ? 'selected' : '' }}>{{ trans('user.statuss.inactive') }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="role" class="form-label">{{ trans('user.label.role') }}</label>
                        <select class="form-select" id="role" name="role" aria-label="Default select example">
                            {{-- <option value="{{ Request::get('role') != '' ? Request::get('role') : '' }}"
                                {{ Request::get('role') != '' ? 'selected' : '' }}>
                                {{ Request::get('role') != '' ? (Request::get('role') == 1 ? trans('user.statuss.active') : trans('user.statuss.inactive')) : trans('user.select.role') }}
                            </option> --}}
                            <option value="" {{ Request::get('role') == '' ? 'selected' : '' }}>{{ trans('app.all') }}</option>
                            <option value="1" {{ Request::get('role') == '1' ? 'selected' : '' }}>{{ trans('app.student') }}</option>
                            <option value="2" {{ Request::get('role') == '2' ? 'selected' : '' }}>{{ trans('app.teacher') }}</option>
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
                        {{-- <th>{{ trans('user.role') }}</th> --}}
                        <th>{{ trans('user.account') }}</th>
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
                            <td>
                                <span
                                    class="badge rounded-pill text-capitalize bg-{{ match($user->role()){ 1 => 'info', 2 => 'primary', 3 => 'warning'} }}">
                                    {{ match($user->role()){ 1 => trans('app.student'), 2 => trans('teacher.active'), 3 => trans('teacher.inactive')} }}
                                </span>
                            </td>
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

                                        @if ($user->teacher)
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#createAdModal{{$user->teacher->id}}">
                                        <i class='bx bxs-megaphone me-2'></i>
                                        {{ trans('ad.create') }}
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                            data-bs-target="#UpdateTeacherStatusModal{{ $user->id }}">
                                            <i class='bx bx-analyse me-2'></i>
                                            {{ $user->role() == 3 ? trans('teacher.activate') : trans('teacher.deactivate') }}
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
                        </tr>

                        @include('dashboard.user.upgrade')
                        @include('dashboard.user.update-status')
                        @include('dashboard.user.delete')
                        @if ($user->teacher)
                          @include('dashboard.user.create')
                          @include('dashboard.user.update-teacher-status')
                        @endif
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
                }, 1000);

            });

            $('#role').on('change', function(event) {
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
                }, 1000);

            })

            function submitForm() {
                $("#searchUserForm").submit();
            }

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
        });
    </script>
@endsection

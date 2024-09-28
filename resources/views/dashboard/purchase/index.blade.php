@extends('layouts/contentNavbarLayout')

@section('title', trans('purchase.purchases'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
    <script src="https://unpkg.com/htmx.org@2.0.0" integrity="sha384-wS5l5IKJBvK6sPTKa2WZ1js3d947pvWXbPJ1OmWfEuxLgeHcEbjUUA5i9V5ZkpCw" crossorigin="anonymous"></script>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('purchase.purchases') }}
    </h4>
@endsection

@section('content')
    <div class="card">
        <h5 class="card-header pt-0 mt-2">
            <form action="" method="GET" id="searchCourseForm">
                <div class="row">
                    <div class="form-group col-md-3" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="name" class="form-label">{{ trans('purchase.label.status') }}</label>
                        <select class="form-select" id="status" name="status" aria-label="Default select example">
                            <option value="">{{ trans('app.all') }}</option>
                            <option value="pending" {{ Request::get('status') == 'pending' ? 'selected' : '' }}>
                                {{ trans('app.status.Pending') }}</option>
                            <option value="success" {{ Request::get('status') == 'success' ? 'selected' : '' }}>
                                {{ trans('app.status.Accepted') }}</option>
                            <option value="failed" {{ Request::get('status') == 'failed' ? 'selected' : '' }}>
                                {{ trans('app.status.Refused') }}</option>
                        </select>
                    </div>

                    {{-- <div class="form-group col-md-3">
                        <label for="subject" class="form-label">{{ trans('purchase.label.subject') }}</label>
                        <select class="form-select" id="subject" name="subject" aria-label="Default select example">
                            <option value="">{{ trans('purchase.select.subject') }}</option>
                            <option value="">{{ trans('app.all') }}</option>

                            @foreach ($subjects as $item => $subject)
                                <option value="{{ $subject->{'name_' . config('app.locale')} }}"
                                    {{ $subject->{'name_' . config('app.locale')} == Request::get('subject') ? 'selected' : '' }}>
                                    {{ $subject->{'name_' . config('app.locale')} }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="teacher" class="form-label">{{ trans('purchase.label.teacher') }}</label>
                        <select class="form-select" id="teacher" name="teacher" aria-label="Default select example">
                            <option value="">{{ trans('purchase.select.teacher') }}</option>
                            <option value="">{{ trans('app.all') }}</option>

                            @foreach ($teachers as $item => $teacher)
                                <option value="{{ $teacher->user->name }}"
                                    {{ $teacher->user->name == Request::get('teacher') ? 'selected' : '' }}>
                                    {{ $teacher->user->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="form-group col-md-3">
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
                        <th>{{ trans('purchase.course') }}</th>
                        <th>{{ trans('purchase.student') }}</th>
{{--                         <th>{{ trans('purchase.teacher') }}</th>
                        <th>{{ trans('purchase.price') }}</th> --}}
                        <th>{{ trans('purchase.created') }}</th>
                        <th>{{ trans('purchase.status') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchases as $key => $purchase)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $purchase->course->name }}</td>
                            <td>{{ $purchase->student->user->name}}</td>
{{--                             <td>{{ $purchase->course->teacher->user->name }}</td>
                            <td>{{ $purchase->total }}</td> --}}
                            <td>{{ $purchase->created_at() }}</td>
                            {{-- <td class="align-middle" style="direction: ltr">@money($purchase->price)</td> --}}
                            <td>
                                @if ($purchase->status == 'pending')
                                    <span class="badge rounded-pill text-capitalize bg-warning">
                                        {{ trans('app.status.Pending') }}
                                    </span>
                                @elseif($purchase->status == 'success')
                                    <span class="badge rounded-pill text-capitalize bg-success">
                                        {{ trans('app.status.Accepted') }}
                                    </span>
                                @else
                                    <span class="badge rounded-pill text-capitalize bg-danger">
                                        {{ trans('app.status.Refused') }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#infoModal{{ $purchase->id }}">
                                                <i class='bx bxs-info-circle me-2'></i>
                                                {{ trans('purchase.info') }}
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#transactionModal{{ $purchase->id }}">
                                                <i class='bx bxs-credit-card me-2'></i>
                                                {{ trans('purchase.transaction') }}
                                            </a>
                                        @if ($purchase->used_coupons()->count())
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#usedCouponsModal{{ $purchase->id }}">
                                                <i class='bx bxs-discount me-2'></i>
                                                {{ trans('purchase.coupons') }}
                                            </a>

                                        @endif

                                        {{-- @if ($purchase->status != 'success')
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#deleteCourseModal{{ $purchase->id }}">
                                                <i class="bx bx-trash me-2"></i>
                                                {{ trans('purchase.delete') }}
                                            </a>
                                        @endif

                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#createAdModal{{$purchase->id}}">
                                                <i class='bx bxs-megaphone me-2'></i>
                                                {{ trans('ad.create') }}
                                        </a>

                                        <a class="dropdown-item" href="{{ route('dashboard.purchases.show', $purchase->id) }}">
                                            <i class="bx bx-show me-2"></i>
                                            {{ trans('purchase.show') }}
                                        </a> --}}


                                    </div>
                                    @include('dashboard.purchase.coupons')
                                    @include('dashboard.purchase.info')
                                    @include('dashboard.purchase.transaction')
                                </div>
                            </td>
                        </tr>

                        {{-- @include('dashboard.purchase.create')
                        @include('dashboard.purchase.delete')
                        @include('dashboard.purchase.approved')
                        @include('dashboard.purchase.reject') --}}
                    @endforeach
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

            $('#subject').on('change', function(event) {
                // $("#name").focus();

                timer = setTimeout(function() {
                    submitForm();
                }, 1000);

            });
            $('#teacher').on('change', function(event) {
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
                $("#searchCourseForm").submit();
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

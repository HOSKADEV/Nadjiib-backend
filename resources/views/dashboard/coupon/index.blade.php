@extends('layouts/contentNavbarLayout')

@section('title', trans('coupon.coupons'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('coupon.coupons') }}
    </h4>
@endsection

@section('content')
    @include('dashboard.coupon.create')
    <div class="card">
        <h5 class="card-header pt-0 mt-1">
            <div class="row  justify-content-between">
                <div class="form-group col-md-4 mr-5 mt-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCouponModal">
                        <span class="tf-icons bx bx-plus"></span>&nbsp; {{ trans('coupon.create') }}
                    </button>
                </div>
                {{-- <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                    <form action="" method="GET" id="searchSectionForm">
                        <label for="name" class="form-label">{{ trans('section.label.name') }}</label>
                        <input type="text" id="name" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-solid"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('section.placeholder.name') }}">
                    </form>
                </div> --}}
            </div>

        </h5>
        <div class="table-responsive text-nowrap">

            <table class="table mb-2">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>{{ trans('coupon.code') }}</th>
                        <th>{{ trans('coupon.discount') }}</th>
                        {{-- <th>{{ trans('coupon.type') }}</th> --}}
                        <th>{{ trans('coupon.start_date') }}</th>
                        <th>{{ trans('coupon.end_date') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupons as $key => $coupon)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ $coupon->discount . '%' }}</td>
                            {{-- <td>{{ $coupon->type }}</td> --}}
                            <td>{{ $coupon->start_date() }}</td>
                            <td>{{ $coupon->end_date() }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info mx-1"
                                    data-bs-toggle="modal" data-bs-target="#editCouponModal{{ $coupon->id }}"
                                >
                                    <i class='bx bxs-edit'></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger mx-1"
                                    data-bs-toggle="modal" data-bs-target="#deleteCouponModal{{ $coupon->id }}"
                                >
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                        @include('dashboard.coupon.edit')
                        @include('dashboard.coupon.delete')
                    @endforeach
                </tbody>
            </table>
            {{ $coupons->links() }}
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            var randomString = function(len){
                var charSet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                var randomString = '';
                for (var i = 0; i < len; i++) {
                    var randomPoz = Math.floor(Math.random() * charSet.length);
                    randomString += charSet.substring(randomPoz,randomPoz+1);
                }
                return randomString;
            }
            $("#code").val(randomString(8));



            $('#generate').on('click',function(){
                console.log(randomString(8));
                $("#code").val(randomString(8));
            });

            $('#name').on('keyup', function(event) {
                $("#name").focus();

                timer = setTimeout(function() {
                    submitForm();
                }, 1000);

                function submitForm() {
                    $("#searchSectionForm").submit();
                }
            });
        });
    </script>
@endsection

@extends('layouts/contentNavbarLayout')

@section('title', trans('user.wallet'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
    <script src="https://unpkg.com/htmx.org@2.0.0" integrity="sha384-wS5l5IKJBvK6sPTKa2WZ1js3d947pvWXbPJ1OmWfEuxLgeHcEbjUUA5i9V5ZkpCw" crossorigin="anonymous"></script>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('user.wallet') }}
    </h4>
@endsection

@section('content')
    {{-- @include('dashboard.coupon.create') --}}
<div class="card">
        <h5 class="card-header pt-1 mt-1">

            <form action="" method="GET" id="searchUserForm">
              <div class="row mb-1 py-3">
                <h6>{{$userName}} :<span  class=""> {{$balance}} Dzd</spane><h6>
              </div>
                <div class="row">
                    <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="name" class="form-label">{{ trans('wallet.label.status') }}</label>
                        <select class="form-select" id="status" name="status" aria-label="Default select example">
                            {{-- <option value="{{ Request::get('status') != '' ? Request::get('status') : '' }}"
                                {{ Request::get('status') != '' ? 'selected' : '' }}>
                                {{ Request::get('status') != '' ? (Request::get('status') == 'ACTIVE' ? trans('user.statuss.active') : trans('user.statuss.inactive')) : trans('user.select.status') }} --}}
                            </option>
                            <option value="" {{ Request::get('status') == '' ? 'selected' : '' }}>{{ trans('app.all') }}</option>
                            <option value="{{ App\Enums\WalletTransactionStatus::SUCCESS}}" {{ Request::get('status') == App\Enums\WalletTransactionStatus::SUCCESS ? 'selected' : '' }}>{{ trans('wallet.statuss.success') }}</option>
                            <option value="{{ App\Enums\WalletTransactionStatus::FAILED}}" {{ Request::get('status') == App\Enums\WalletTransactionStatus::FAILED ? 'selected' : '' }}>{{ trans('wallet.statuss.failed') }}</option>
                            <option value="{{App\Enums\WalletTransactionStatus::PENDING}}" {{ Request::get('status') == App\Enums\WalletTransactionStatus::PENDING ? 'selected' : '' }}>{{ trans('wallet.statuss.pending') }}</option>

                        </select>
                    </div>
                    <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="name" class="form-label">{{ trans('wallet.label.type') }}</label>
                        <select class="form-select" id="type" name="type" aria-label="Default select example">
                            {{-- <option value="{{ Request::get('status') != '' ? Request::get('status') : '' }}"
                                {{ Request::get('status') != '' ? 'selected' : '' }}>
                                {{ Request::get('status') != '' ? (Request::get('status') == 'ACTIVE' ? trans('user.statuss.active') : trans('user.statuss.inactive')) : trans('user.select.status') }} --}}
                            </option>
                            <option value="" {{ Request::get('type') == '' ? 'selected' : '' }}>{{ trans('app.all') }}</option>
                            <option value="{{ App\Enums\WalletAction::BUY}}" {{ Request::get('type') == App\Enums\WalletAction::BUY ? 'selected' : '' }}>{{ trans('wallet.types.buy') }}</option>
                            <option value="{{ App\Enums\WalletAction::DEPOSIT}}" {{ Request::get('type') == App\Enums\WalletAction::DEPOSIT ? 'selected' : '' }}>{{ trans('wallet.types.deposit') }}</option>

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
                        <th>{{ trans('wallet.label.type') }}</th>
                        <th>{{ trans('wallet.label.amount') }}</th>
                        <th>{{ trans('wallet.label.description') }}</th>
                        <th>{{ trans('wallet.label.status') }}</th>

                        <th>{{ trans('wallet.label.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $key => $tr)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td class="td-3">{{App\Enums\WalletAction::get($tr->type)}}</td>
                            <td class="td-3">{{ $tr->amount }}</td>
                            <td class="td-3">{{ $tr->description }}</td>
                            <td class="td-3">{{App\Enums\WalletTransactionStatus::get($tr->status)}}</td>
                            <td class="td-3">
                              <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#transactionModal{{ $tr->id }}">
                                        <i class='bx bxs-credit-card me-2'></i>
                                        {{ trans('purchase.transaction') }}
                                    </a>
                                    @if ($tr->status != 'success')
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                            data-bs-target="#acceptPurchaseModal{{ $tr->id }}">
                                            <i class="bx bxs-check-square me-2"></i>
                                            {{ trans('purchase.accept') }}
                                        </a>
                                    @endif

                                    @if ($tr->status == 'pending')
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                            data-bs-target="#refusePurchaseModal{{ $tr->id }}">
                                            <i class="bx bxs-x-square me-2"></i>
                                            {{ trans('purchase.refuse') }}
                                        </a>
                                    @endif

                                </div>
                                @include('dashboard.user.transaction-info')
                                @include('dashboard.user.accept')
                                @include('dashboard.user.refuse')
                            </div>
                            </td>

                        </tr>

                    @endforeach
                </tbody>
            </table>
            {{ $transactions->links() }}
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


        });
    </script>
@endsection

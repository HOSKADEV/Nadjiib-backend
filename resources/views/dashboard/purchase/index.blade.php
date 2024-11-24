@extends('layouts/contentNavbarLayout')

@section('title', trans('purchase.purchases'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
    <script src="https://unpkg.com/htmx.org@2.0.0"
        integrity="sha384-wS5l5IKJBvK6sPTKa2WZ1js3d947pvWXbPJ1OmWfEuxLgeHcEbjUUA5i9V5ZkpCw" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
    integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('vendor-style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .hiddenRow {
            padding: 0 !important;
        }
    </style>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('purchase.purchases') }}
    </h4>
@endsection

@section('content')
    <div class="card">
        <h5 class="card-header pt-0 mt-2">
            <form action="" method="GET" id="searchForm">
                <div class="row">
                    {{-- <div class="form-group col-md-3" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="name" class="form-label">{{ trans('purchase.status') }}</label>
                        <select class="form-select" id="status" name="status" aria-label="Default select example">
                            <option value="">{{ trans('app.all') }}</option>
                            <option value="pending" {{ Request::get('status') == 'pending' ? 'selected' : '' }}>
                                {{ trans('app.status.Pending') }}</option>
                            <option value="success" {{ Request::get('status') == 'success' ? 'selected' : '' }}>
                                {{ trans('app.status.Accepted') }}</option>
                            <option value="failed" {{ Request::get('status') == 'failed' ? 'selected' : '' }}>
                                {{ trans('app.status.Refused') }}</option>
                        </select>
                    </div> --}}



                    <div class="form-group col-md-3">
                        <label for="search" class="form-label">{{ trans('user.label.search') }}</label>
                        <input type="text" id="search" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-solid"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('purchase.search_placeholder') }}">
                    </div>

                    <div class="form-group col-md-3">
                      <label for="date" class="form-label">{{ trans('payment.date') }}</label>

                      <div class="input-group input-group-merge">
                          <input type="text" readonly="readonly" id="date" name="date"
                              class="form-control input-solid" value="">
                          <span class="input-group-text cursor-pointer"><i class='bx bx-calendar'></i></span>
                      </div>
                  </div>

                </div>
            </form>

        </h5>
        <div class="table-responsive text-nowrap">

            <table class="table mb-2" id="shown_table">
                <thead>
                    <tr class="text-nowrap">
                        <th></th>
                        <th>{{ trans('purchase.course') }}</th>
                        <th>{{ trans('purchase.student') }}</th>
                        {{-- <th>{{ trans('purchase.teacher') }}</th>
                        <th>{{ trans('purchase.price') }}</th> --}}
                        <th>{{ trans('purchase.created') }}</th>
                        <th>{{ trans('purchase.status') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchases as $key => $purchase)
                        @php
                            $attempts = $purchase->attempts();
                        @endphp

                        <tr data-toggle="collapse" data-target="#demo{{ $key }}" class="accordion-toggle"
                            onclick="toggleIcon(this)">
                            <td class="td-1">
                                @if ($attempts->count() > 1)
                                    <i class='bx bx-chevron-down toggle-icon'></i>
                                @endif
                            </td>
                            <td class="td-2">{{ $purchase->course_name }}</td>
                            <td class="td-3">{{ $purchase->user_name }}</td>
                            <td class="td-4">{{ $purchase->created_at() }}</td>
                            @if ($attempts->count() > 1)
                                <td class="td-5"></td>
                                <td class="td-6"></td>
                            @else
                                @php
                                    $purchase = $attempts->first();
                                @endphp
                                <td class="td-5">
                                    @if ($purchase->status == 'pending')
                                        <span class="badge rounded-pill text-capitalize bg-warning">
                                            {{ trans('purchase.pending') }}
                                        </span>
                                    @elseif($purchase->status == 'success')
                                        <span class="badge rounded-pill text-capitalize bg-success">
                                            {{ trans('purchase.accepted') }}
                                        </span>
                                    @else
                                        <span class="badge rounded-pill text-capitalize bg-danger">
                                            {{ trans('purchase.refused') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="td-6">
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

                                            @if ($purchase->status != 'success')
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#acceptPurchaseModal{{ $purchase->id }}">
                                                    <i class="bx bxs-check-square me-2"></i>
                                                    {{ trans('purchase.accept') }}
                                                </a>
                                            @endif

                                            @if ($purchase->status == 'pending')
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#refusePurchaseModal{{ $purchase->id }}">
                                                    <i class="bx bxs-x-square me-2"></i>
                                                    {{ trans('purchase.refuse') }}
                                                </a>
                                            @endif

                                        </div>
                                        @include('dashboard.purchase.coupons')
                                        @include('dashboard.purchase.info')
                                        @include('dashboard.purchase.transaction')
                                        @include('dashboard.purchase.accept')
                                        @include('dashboard.purchase.refuse')
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @if ($attempts->count() > 1)
                            <tr>
                                <td colspan="6" class="hiddenRow">
                                    <div class="accordian-body collapse" id="demo{{ $key }}">
                                        <table class="table table-condensed hidden_table">
                                            <tbody>
                                                @foreach ($attempts as $key => $attempt)
                                                    <tr class="table-secondary">
                                                        <td class="td-1"></td>
                                                        <td class="td-2">{{ $attempt->course->name }}</td>
                                                        <td class="td-3">{{ $attempt->student->user->name }}</td>
                                                        <td class="td-4">{{ $attempt->created_at() }}</td>
                                                        <td class="td-5">
                                                            @if ($attempt->status == 'pending')
                                                                <span class="badge rounded-pill text-capitalize bg-warning">
                                                                    {{ trans('purchase.pending') }}
                                                                </span>
                                                            @elseif($attempt->status == 'success')
                                                                <span class="badge rounded-pill text-capitalize bg-success">
                                                                    {{ trans('purchase.accepted') }}
                                                                </span>
                                                            @else
                                                                <span class="badge rounded-pill text-capitalize bg-danger">
                                                                    {{ trans('purchase.refused') }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td class="td-6">
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#infoModal{{ $attempt->id }}">
                                                                        <i class='bx bxs-info-circle me-2'></i>
                                                                        {{ trans('purchase.info') }}
                                                                    </a>
                                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#transactionModal{{ $attempt->id }}">
                                                                        <i class='bx bxs-credit-card me-2'></i>
                                                                        {{ trans('purchase.transaction') }}
                                                                    </a>
                                                                    @if ($attempt->used_coupons()->count())
                                                                        <a class="dropdown-item"
                                                                            href="javascript:void(0);"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#usedCouponsModal{{ $attempt->id }}">
                                                                            <i class='bx bxs-discount me-2'></i>
                                                                            {{ trans('purchase.coupons') }}
                                                                        </a>
                                                                    @endif

                                                                    @if ($attempt->status != 'success')
                                                                        <a class="dropdown-item"
                                                                            href="javascript:void(0);"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#acceptPurchaseModal{{ $attempt->id }}">
                                                                            <i class="bx bxs-check-square me-2"></i>
                                                                            {{ trans('purchase.accept') }}
                                                                        </a>
                                                                    @endif

                                                                    @if ($attempt->status == 'pending')
                                                                        <a class="dropdown-item"
                                                                            href="javascript:void(0);"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#refusePurchaseModal{{ $attempt->id }}">
                                                                            <i class="bx bxs-x-square me-2"></i>
                                                                            {{ trans('purchase.refuse') }}
                                                                        </a>
                                                                    @endif

                                                                </div>
                                                                @include('dashboard.purchase.coupons', [
                                                                    'purchase' => $attempt,
                                                                ])
                                                                @include('dashboard.purchase.info', [
                                                                    'purchase' => $attempt,
                                                                ])
                                                                @include('dashboard.purchase.transaction', [
                                                                    'purchase' => $attempt,
                                                                ])
                                                                @include('dashboard.purchase.accept', [
                                                                    'purchase' => $attempt,
                                                                ])
                                                                @include('dashboard.purchase.refuse', [
                                                                    'purchase' => $attempt,
                                                                ])
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        @endif
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
          $("#date").datepicker({
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months"
            });
            // search
            $('#search').on('keyup change blur', function(event) {
                $("#search").focus();
                timer = setTimeout(function() {
                    submitForm();
                }, 1000);

            })

            function submitForm() {
                $("#searchForm").submit();
            }

            function adjustColumnWidths() {
                // Iterate through each column class
                for (let i = 1; i <= 6; i++) {
                    let maxWidth = 0;
                    let className = `td-${i}`;

                    // Find the maximum width for this column class
                    $(`.${className}`).each(function() {
                        // Temporarily remove any existing width to get the natural width
                        $(this).css('width', '');
                        let width = $(this).outerWidth();
                        if (width > maxWidth) {
                            maxWidth = width;
                        }
                    });

                    // Apply the maximum width to all elements of this class
                    $(`.${className}`).each(function() {
                        $(this).css({
                            'width': `${maxWidth}px`,
                            'min-width': `${maxWidth}px`,
                            'max-width': `${maxWidth}px`
                        });
                        // Force a reflow
                        void this.offsetWidth;
                    });
                }
            }

            // Call the function when the page loads
            adjustColumnWidths();

            // Optionally, call the function when the window is resized
            $(window).resize(adjustColumnWidths);
        });
    </script>

@endsection

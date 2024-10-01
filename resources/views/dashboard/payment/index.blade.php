@extends('layouts/contentNavbarLayout')

@section('title', trans('payment.payments'))

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
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('payment.payments') }}
    </h4>
@endsection

@section('content')
    <div class="card">
        <h5 class="card-header pt-0 mt-2">
            <form action="" method="GET" id="searchForm">
                <div class="row">
                    {{-- <div class="form-group col-md-3" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="name" class="form-label">{{ trans('payment.status') }}</label>
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
                        <label for="date" class="form-label">{{ trans('payment.date') }}</label>

                        <div class="input-group input-group-merge">
                            <input type="text" readonly="readonly" id="date" name="date" class="form-control input-solid" value={{$date->month.'-'.$date->year}}>
                            <span class="input-group-text cursor-pointer"><i class='bx bx-calendar'></i></span>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="search" class="form-label">{{ trans('user.label.search') }}</label>
                        <input type="text" id="search" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-solid"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('payment.search_placeholder') }}">
                    </div>
                </div>
            </form>

        </h5>
        <div class="table-responsive text-nowrap">

            <table class="table mb-2" id="shown_table">
                <thead>
                    <tr class="text-nowrap">
                        <th></th>
                        <th>{{ trans('payment.teacher') }}</th>
                        <th>{{ trans('payment.amount') }}</th>
                        <th>{{ trans('payment.date') }}</th>
                        <th>{{ trans('payment.status') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $key => $payment)
                    <tr>
                            <th>{{$key+1}}</th>
                        <td>{{ $payment->teacher->user->name }}</td>
                        <td>{{ $payment->amount }}</td>
                        <td>{{ $payment->date }}</td>
                        <td>@if ($payment->status() == 2)
                          <span class="badge rounded-pill text-capitalize bg-success">
                              {{ trans('payment.confirmed') }}
                          </span>
                      @elseif($payment->status() == 1)
                          <span class="badge rounded-pill text-capitalize bg-warning">
                              {{ trans('payment.paid') }}
                          </span>
                      @else
                          <span class="badge rounded-pill text-capitalize bg-danger">
                              {{ trans('payment.unpaid') }}
                          </span>
                      @endif</td>
                      <td>
                        <button type="button" class="btn btn-sm btn-warning mx-1" data-bs-toggle="modal"
                                    data-bs-target="#videoModal{{ $payment->id }}">
                                    <i class='bx bx-money'></i>
                                </button>

                                <!-- File button -->
                                <button type="button" class="btn btn-sm btn-info mx-1" data-bs-toggle="modal"
                                    data-bs-target="#fileModal{{ $payment->id }}">
                                    <i class='bx bx-purchase-tag'></i>
                                </button>
                      </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $payments->links() }} --}}
        </div>
    </div>

@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            $("#date").datepicker({
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months"
            });

            $('#search').on('keyup change blur', function(event) {
                $("#search").focus();
                timer = setTimeout(function() {
                    submitForm();
                }, 1000);

            })

            $('#date').on('change blur', function(event) {
                $("#search").focus();
                timer = setTimeout(function() {
                    submitForm();
                }, 1000);

            })

            function submitForm() {
                $("#searchForm").submit();
            }
        });
    </script>
@endsection

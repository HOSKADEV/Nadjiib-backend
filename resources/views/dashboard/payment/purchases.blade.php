@extends('layouts/contentNavbarLayout')

@section('title', trans('purchase.purchases'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}">
    </script>
    <script src="https://unpkg.com/htmx.org@2.0.0"
        integrity="sha384-wS5l5IKJBvK6sPTKa2WZ1js3d947pvWXbPJ1OmWfEuxLgeHcEbjUUA5i9V5ZkpCw" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.js"></script>
@endsection

@section('vendor-style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css" />
    <style>
        .hiddenRow {
            padding: 0 !important;
        }
    </style>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">
        <span class="text-muted fw-light">{{ trans('payment.purchases') }} / </span>{{ $payment->teacher->user->name }}
    </h4>
@endsection

@section('content')
    <div class="card">
        <h5 class="card-header pt-0 mt-2">
            <form action="" method="GET" id="searchForm">
                <div class="row">


                    <div class="form-group col-md-3">
                        <label for="search" class="form-label">{{ trans('user.label.search') }}</label>
                        <input type="text" id="search" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-solid"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('purchase.search_placeholder') }}">
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
                        <th>{{ trans('course.price') }}</th>
                        <th>{{ trans('purchase.total_percentage') }}</th>
                        <th>{{ trans('purchase.total_amount') }}</th>
                        {{-- <th>{{ trans('app.actions') }}</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchases->items() as $key => $purchase)
                        <tr data-toggle="collapse" data-target="#demo{{ $key }}" class="accordion-toggle"
                            onclick="toggleIcon(this)">

                            <td class="td-1">
                                @if ($purchase->bonuses()->count() > 1)
                                    <i class='bx bx-chevron-down toggle-icon'></i>
                                @endif
                            </td>
                            <td class="td-2">{{ $purchase->course->name }}</td>
                            <td class="td-3">{{ $purchase->student->user->name }}</td>
                            <td class="td-4">{{ $purchase->created_at() }}</td>
                            <td class="td-5">{{ $purchase->course->price }}</td>
                            <td class="td-6">{{ $purchase->bonuses()->sum('percentage') }}%</td>
                            <td class="td-7">{{ $purchase->bonuses()->sum('amount') }}</td>
                        </tr>
                        @if ($purchase->bonuses()->count() > 1)
                            <tr>
                                <td colspan="7" class="hiddenRow">
                                    <div class="accordian-body collapse" id="demo{{ $key }}">
                                        <table class="table table-condensed hidden_table">
                                          <thead class="table-secondary">
                                            <th></th>
                                            <th>{{ trans('purchase.bonus.type') }}</th>
                                            <th></th>
                                            <th>{{ trans('purchase.bonus.created') }}</th>
                                            <th>{{ trans('course.price') }}</th>
                                            <th>{{ trans('purchase.bonus.percentage') }}</th>
                                            <th>{{ trans('purchase.bonus.amount') }}</th>
                                        </thead>
                                            <tbody>
                                                @foreach ($purchase->bonuses as $key => $bonus)
                                                    <tr class="table-secondary">
                                                        <td class="td-1"></td>
                                                        {{--<td class="td-2"></td>
                                                         <td class="td-2">{{ $purchase->course->name }}</td>
                                                        <td class="td-3">{{ $purchase->student->user->name }}</td> --}}
                                                        <td class="td-2">{{ $bonus->type() }}</td>
                                                        <td class="td-3"></td>
                                                        <td class="td-4">{{ $bonus->created_at() }}</td>
                                                        <td class="td-5">{{ $purchase->course->price }}</td>
                                                        <td class="td-6">{{ $bonus->percentage }}%</td>
                                                        <td class="td-7">{{ $bonus->amount }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            {{-- <tfoot class="table-secondary">
                                              <th></th>
                                              <th></th>
                                              <th>{{ trans('bonus.type') }}</th>
                                              <th>{{ trans('bonus.ceated') }}</th>
                                              <th>{{ trans('bonus.percentage') }}</th>
                                              <th>{{ trans('bonus.amount') }}</th>
                                            </tfoot> --}}
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
                <tfoot>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{ trans('app.total') }}</th>
                    <th>{{ $payment->bonuses()->sum('amount') }}</th>
                </tfoot>
            </table>
            {{ $purchases->links() }}
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

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
                for (let i = 1; i <= 7; i++) {
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

@extends('layouts/contentNavbarLayout')

@section('title', trans('notice.notices'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('notice.notices') }}
    </h4>
@endsection
@section('content')
    @include('dashboard.notice.create')
    <div class="card">
        <h5 class="card-header pt-0 mt-1">
            <div class="row  justify-content-between">
                <div class="form-group col-md-4 mr-5 mt-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNoticeModal">
                        <span class="tf-icons bx bx-plus"></span>&nbsp; {{ trans('notice.create') }}
                    </button>
                </div>

                <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                    <form action="" method="GET" id="searchNoticeForm">
                        <label for="name" class="form-label">{{ trans('notice.label.title') }}</label>
                        <input type="text" id="name" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-solid"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('notice.placeholder.title') }}">
                    </form>
                </div>
            </div>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table mb-2">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>{{ trans('notice.title') }}</th>
                        <th>{{ trans('notice.content') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notices as $key => $notice)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $notice->title(Session::get('locale')) }}</td>
                            <td><textarea rows="2" class="form-control">{{ $notice->content(Session::get('locale')) }}</textarea></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info mx-1"
                                    data-bs-toggle="modal" data-bs-target="#editNoticeModal{{ $notice->id }}"
                                >
                                    <i class='bx bxs-edit'></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger mx-1"
                                    data-bs-toggle="modal" data-bs-target="#deleteNoticeModal{{ $notice->id }}"
                                >
                                    <i class='bx bx-trash'></i>
                                </button>

                                <button type="button" class="btn btn-sm btn-warning mx-1"
                                    data-bs-toggle="modal" data-bs-target="#broadcastNoticeModal{{ $notice->id }}"
                                >
                                    <i class='bx bx-paper-plane'></i>
                                </button>
                            </td>
                        </tr>
                        @include('dashboard.notice.edit')
                        @include('dashboard.notice.delete')
                        @include('dashboard.notice.broadcast')
                    @endforeach
                </tbody>
            </table>
            {{ $notices->links() }}
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#name').on('keyup', function(event) {
                $("#name").focus();

                timer = setTimeout(function() {
                    submitForm();
                }, 1000);

                function submitForm() {
                    $("#searchNoticeForm").submit();
                }
            });
        });
    </script>
@endsection

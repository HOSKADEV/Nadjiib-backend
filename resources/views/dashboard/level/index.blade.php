@extends('layouts/contentNavbarLayout')

@section('title', trans('level.levels'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('level.levels') }}
    </h4>
@endsection

@section('content')
    @include('dashboard.level.create')
    <div class="card">
        <h5 class="card-header pt-0 mt-1">
            <div class="row  justify-content-between">
                <div class="form-group col-md-4 mr-5 mt-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createLevelModal">
                        <span class="tf-icons bx bx-plus"></span>&nbsp; {{ trans('level.create') }}
                    </button>
                </div>
                <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                    <form action="" method="GET" id="searchLevelForm">
                        <label for="name" class="form-label">{{ trans('level.label.name') }}</label>
                        <input type="text" id="name" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-solid"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('level.placeholder.name') }}">
                    </form>
                </div>
            </div>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table mb-2">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>{{ trans('level.name_en') }}</th>
                        <th>{{ trans('level.name_fr') }}</th>
                        <th>{{ trans('level.name_ar') }}</th>
                        <th>{{ trans('level.image') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($levels as $key => $level)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $level->name_ar }}</td>
                            <td>{{ $level->name_en }}</td>
                            <td>{{ $level->name_fr }}</td>
                            <td>Table cell</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info mx-1"
                                    data-bs-toggle="modal" data-bs-target="#editLevelModal{{ $level->id }}"
                                >
                                    <i class='bx bxs-edit'></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger mx-1"
                                    data-bs-toggle="modal" data-bs-target="#deleteLevelModal{{ $level->id }}"
                                >
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                        @include('dashboard.level.edit')
                        @include('dashboard.level.delete')
                    @endforeach
                </tbody>
            </table>
            {{ $levels->links() }}
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
                }, 4000);

                function submitForm() {
                    $("#searchLevelForm").submit();
                }
            });
        });
    </script>
@endsection

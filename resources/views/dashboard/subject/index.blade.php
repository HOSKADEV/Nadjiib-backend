@extends('layouts/contentNavbarLayout')

@section('title', trans('subject.subjects'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('subject.subjects') }}
    </h4>
@endsection
@section('content')
    @include('dashboard.subject.create')
    <div class="card">
        <h5 class="card-header pt-0 mt-1">
            <div class="row  justify-content-between">
                <div class="form-group col-md-4 mr-5 mt-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSubjectModal">
                        <span class="tf-icons bx bx-plus"></span>&nbsp; {{ trans('subject.create') }}
                    </button>
                </div>
                <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                    <form action="" method="GET" id="searchSubjectForm">
                        <label for="name" class="form-label">{{ trans('subject.label.name') }}</label>
                        <input type="text" id="name" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-solid"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('subject.placeholder.name') }}">
                    </form>
                </div>
            </div>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table mb-2">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>{{ trans('subject.name_en') }}</th>
                        <th>{{ trans('subject.name_fr') }}</th>
                        <th>{{ trans('subject.name_ar') }}</th>
                        <th>{{ trans('subject.image') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subjects as $key => $subject)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $subject->name_ar }}</td>
                            <td>{{ $subject->name_en }}</td>
                            <td>{{ $subject->name_fr }}</td>
                            <td>Table cell</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info mx-1"
                                    data-bs-toggle="modal" data-bs-target="#editSubjectModal{{ $subject->id }}"
                                >
                                    <i class='bx bxs-edit'></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger mx-1"
                                    data-bs-toggle="modal" data-bs-target="#deleteSubjectModal{{ $subject->id }}"
                                >
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                        @include('dashboard.subject.edit')
                        @include('dashboard.subject.delete')
                    @endforeach
                </tbody>
            </table>
            {{ $subjects->links() }}
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
                    $("#searchSubjectForm").submit();
                }
            });
        });
    </script>
@endsection

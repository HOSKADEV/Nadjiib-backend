@extends('layouts/contentNavbarLayout')

@section('title', trans('ad.ads'))

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
    <script src="https://unpkg.com/htmx.org@2.0.0" integrity="sha384-wS5l5IKJBvK6sPTKa2WZ1js3d947pvWXbPJ1OmWfEuxLgeHcEbjUUA5i9V5ZkpCw" crossorigin="anonymous"></script>
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">
        <span class="text-muted fw-light">{{ trans('app.dashboard') }} /</span>{{ trans('ad.ads') }}
    </h4>
@endsection

@section('content')
    @include('dashboard.ad.create')
    <div class="card">
        <form action="" method="GET" id="searchSectionForm">
            <h5 class="card-header pt-0 mt-1">
                <div class="row  justify-content-between">

                    <div class="form-group col-md-4 mr-5 mt-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createAdModal">
                            <span class="tf-icons bx bx-plus"></span>&nbsp; {{ trans('ad.create') }}
                        </button>
                    </div>

                    <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="type" class="form-label">{{ trans('ad.label.type') }}</label>
                        <select class="form-select" id="type_filter" name="type" aria-label="Default select example">
                            {{-- <option value="{{ Request::get('type') != '' ? Request::get('type') : '' }}"
                                {{ Request::get('type') != '' ? 'selected' : '' }}>
                                {{ Request::get('type') != '' ? trans('ad.' . Request::get('type') . 'type') : trans('ad.select.type') }}
                            </option> --}}
                            <option value="" {{ Request::get('type') == '' ? 'selected' : '' }}>{{ trans('app.all') }}</option>
                            <option value="url" {{ Request::get('type') == 'url' ? 'selected' : '' }}>{{ trans('ad.urltype') }}</option>
                            <option value="course" {{ Request::get('type') == 'course' ? 'selected' : '' }}>{{ trans('ad.coursetype') }}</option>
                            <option value="teacher" {{ Request::get('type') == 'teacher' ? 'selected' : '' }}>{{ trans('ad.teachertype') }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="search" class="form-label">{{ trans('ad.label.name') }}</label>
                        <input type="text" id="search" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-solid"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('ad.placeholder.name') }}">

                    </div>

                </div>

            </h5>
        </form>
        <div class="table-responsive text-nowrap">

            <table class="table mb-2">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>{{ trans('ad.name') }}</th>
                        <th>{{ trans('ad.type') }}</th>
                        <th>{{ trans('ad.url') }}</th>
                        <th>{{ trans('ad.created') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ads as $key => $ad)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $ad->name }}</td>
                            <td>
                                @if ($ad->type == 'url')
                                    <span class="badge bg-label-success">{{ trans('ad.urltype') }}</span>
                                @elseif($ad->type == 'course')
                                    <span class="badge bg-label-info">{{ trans('ad.coursetype') }}</span>
                                @elseif($ad->type == 'teacher')
                                    <span class="badge bg-label-warning">{{ trans('ad.teachertype') }}</span>
                                @endif
                            </td>
                            <td>
                                @if (empty($ad->url))
                                    {{ trans('ad.nolink') }}
                                @else
                                    <a href="{{ $ad->url }}"> {{ trans('ad.clicklink') }}</a>
                                @endif
                            </td>
                            <td>{{ $ad->created_at->format('Y-m-d') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info mx-1" data-bs-toggle="modal"
                                    data-bs-target="#editAdModal{{ $ad->id }}">
                                    <i class='bx bxs-edit'></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger mx-1" data-bs-toggle="modal"
                                    data-bs-target="#deleteAdModal{{ $ad->id }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                        @include('dashboard.ad.edit')
                        @include('dashboard.ad.delete')
                    @endforeach
                </tbody>
            </table>
            {{ $ads->links() }}
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            var randomString = function(len) {
                var charSet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                var randomString = '';
                for (var i = 0; i < len; i++) {
                    var randomPoz = Math.floor(Math.random() * charSet.length);
                    randomString += charSet.substring(randomPoz, randomPoz + 1);
                }
                return randomString;
            }

            function submitForm() {
                $("#searchSectionForm").submit();
            }


            $("#code").val(randomString(8));



            $('#generate').on('click', function() {
                console.log(randomString(8));
                $("#code").val(randomString(8));
            });



            $('#type_filter').on('change', function(event) {
                // $("#name").focus();

                timer = setTimeout(function() {
                    submitForm();
                }, 1000);

            });

            $('#search').on('keyup', function(event) {
                $("#search").focus();

                timer = setTimeout(function() {
                    submitForm();
                }, 1000);

            });
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

@extends('layouts/contentNavbarLayout')

@section('title', trans('post.posts'))


@section('vendor-script')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/vendor/js/dropzone.js') }}"></script>
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/dropzone.css') }}" type="text/css" />
@endsection

@section('page-header')
    <h4 class="fw-bold py-3 mb-1 ">{{ trans('post.my_posts') }}</h4>
@endsection
@section('content')
@include('user.post.create')
    <div class="card">
        <h5 class="card-header pt-0 mt-1">
            <form action="" method="GET" id="searchPostForm">
                <div class="row  justify-content-between">
                    <div class="form-group col-md-4 mr-5 mt-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createPostModal">
                            <span class="tf-icons bx bx-plus"></span>&nbsp; {{ trans('post.create') }}
                        </button>
                    </div>

                    <div class="form-group col-md-4" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
                        <label for="name" class="form-label">{{ trans('post.search') }}</label>
                        <input type="text" id="name" name="search" value="{{ Request::get('search') }}"
                            class="form-control input-'.Session::get('theme') == 'dark' ? 'regular' : 'solid' .'"
                            placeholder="{{ Request::get('search') != '' ? '' : trans('post.placeholder') }}">
                    </div>

                </div>
            </form>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table mb-2">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>{{ trans('post.description') }}</th>
                        <th>{{ trans('post.comments') }}</th>
                        <th>{{ trans('post.likes') }}</th>
                        <th>{{ trans('post.video') }}</th>
                        <th>{{ trans('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $key => $post)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>
                                <textarea rows="2" class="form-control">{{ $post->description }}</textarea>
                            </td>
                            <td>{{ $post->comments_count }}</td>
                            <td>{{ $post->likes_count }}</td>
                            <td>

                                <a href="{{ $post->video_url() }}">
                                    <img src="{{ asset(Session::get('theme') == 'dark' ? 'assets/icons/file-video-regular.svg' : 'assets/icons/file-video-solid.svg') }}"
                                        height="30px" width="30px" />
                                </a>

                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger mx-1" data-bs-toggle="modal"
                                    data-bs-target="#deleteLessonModal{{ $post->id }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>

                        @include('user.post.delete')
                    @endforeach

                    {{-- @include('dashboard.post.files')
                    @include('dashboard.post.videos') --}}
                </tbody>
            </table>
            {{ $posts->links() }}
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            /* $('textarea').each(function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            }); */

            function submitForm() {
                $("#searchPostForm").submit();
            }

            $('#name').on('keyup', function(event) {
                $("#name").focus();

                timer = setTimeout(function() {
                    submitForm();
                }, 1000);

            });


            $('.submit-btn').on('click', function(event) {

                const form = $(`#deleteLessonForm${$(this).data('post')}`);
                const submitButton = $(`#submitBtn${$(this).data('post')}`);
                const closeButton = $(`#closeBtn${$(this).data('post')}`);

                closeButton.hide();

                submitButton.html(`<div class="spinner-border spinner-border-lg" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>`);

                submitButton.prop('disabled', true);

                setTimeout(() => {
                    form.submit();
                }, 0);
            });
        });
    </script>
@endsection

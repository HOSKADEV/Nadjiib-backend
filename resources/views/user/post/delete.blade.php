<div class="modal fade" id="deleteLessonModal{{ $post->id}}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
        <form action="{{ route('dashboard.posts.delete') }}" id="deleteLessonForm{{ $post->id}}" method="POST">
            @csrf
            <input type="hidden" name="id" class="form-control" value="{{ $post->id}}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('post.delete') }}</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <p>{{ trans('post.delete_confirmation') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeBtn{{$post->id}}" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ trans('app.close') }}</button>
                    <button type="button" id="submitBtn{{$post->id}}" class="btn btn-danger submit-btn" data-post="{{ $post->id }}">{{ trans('app.delete') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

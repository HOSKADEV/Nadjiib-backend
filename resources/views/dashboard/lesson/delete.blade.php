<div class="modal fade" id="deleteLessonModal{{ $lesson->id}}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
        <form action="{{ route('dashboard.lessons.destroy','test') }}" id="deleteLessonForm{{ $lesson->id}}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id" class="form-control" value="{{ $lesson->id}}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('lesson.delete') }}</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <p>{{ trans('lesson.delete_confirmation') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeBtn{{$lesson->id}}" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ trans('app.close') }}</button>
                    <button type="button" id="submitBtn{{$lesson->id}}" class="btn btn-danger submit-btn" data-lesson="{{ $lesson->id }}">{{ trans('app.delete') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

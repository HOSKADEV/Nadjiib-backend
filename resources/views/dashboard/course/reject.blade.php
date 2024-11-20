<div class="modal fade" id="rejectCourseModal{{ $course->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('dashboard.courses.update', 'test') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="id" name="id" class="form-control" value="{{ $course->id }}">
            <input type="hidden" id="status" name="status" class="form-control" value="0">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('course.reject') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ trans('course.reject_confirmation') }}</p>

                    <div class="mb-3">
                      <label class="form-label" for="reject_reason">{{ trans('course.reject_reason') }}</label>
                      <textarea  class="form-control" name="reject_reason" rows="3" placeholder="{{ trans('course.reject_placeholder') }}"></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">{{ trans('app.close') }}</button>
                    <button type="submit" class="btn btn-danger">{{ trans('app.ok') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

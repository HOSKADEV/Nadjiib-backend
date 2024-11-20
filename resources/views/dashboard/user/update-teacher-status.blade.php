<div class="modal fade" id="UpdateTeacherStatusModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <form action="{{ route('dashboard.teachers.changeStatus', 'test') }}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" id="id" name="id" class="form-control" value="{{ $user->teacher?->id }}">

          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel1">{{ $user->role() == 3 ? trans('teacher.activate') : trans('teacher.deactivate')}}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <p>
                      {{ $user->role() == 3 ? trans('teacher.active_confirmation') : trans('teacher.inactive_confirmation') }}
                  </p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary"
                      data-bs-dismiss="modal">{{ trans('app.close') }}</button>
                  <button type="submit" class="btn btn-primary">{{ trans('app.ok') }}</button>
              </div>
          </div>
      </form>
  </div>
</div>

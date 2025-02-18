<div class="modal fade" id="createAdModal{{$course->id}}" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form class="form-horizontal" hx-post="{{ route('dashboard.ads.store') }}" hx-encoding='multipart/form-data'>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('ad.create') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                          <div hidden><img src="{{asset('assets/img/icons/ad-not-found.jpg')}}" alt="image"
                                  class="d-block rounded" height="120" width="500" id="old-image{{ $course->id }}" /> </div>
                          <img src="{{asset('assets/img/icons/ad-not-found.jpg')}}" alt="image"
                              class="d-block rounded" height="120" width="500" id="uploaded-image{{ $course->id }}" />
                      </div>
                      <div class="button-wrapper" style="text-align: center;">
                          <br>
                          <label for="image{{ $course->id }}" class="btn btn-primary" tabindex="0">
                              <span class="d-none d-sm-block">{{ trans('app.addimage') }}</span>
                              <i class="bx bx-upload d-block d-sm-none"></i>
                              <input class="image-input" type="file" id="image{{$course->id}}" name="image" hidden
                                  accept="image/png, image/jpeg" />
                          </label>
                          <button type="button" class="btn btn-outline-secondary image-reset" id="reset{{$course->id}}">
                              <i class="bx bx-reset d-block d-sm-none"></i>
                              <span class="d-none d-sm-block">{{ trans('app.reset') }}</span>
                          </button>
                          <br>
                          {{-- <small class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</small> --}}
                      </div>
                  </div>
                    </br>

                    <input type="hidden" id="course_id" name="course_id" value="{{$course->id}}"/>

                    <div class="mb-3">
                        <label class="form-label" for="name">{{ trans('ad.name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" />
                    </div>



                    <div class="mb-3">
                        <label class="form-label" for="name">{{ trans('ad.type') }}</label>
                        <input type="text" class="form-control" value="{{ trans('ad.coursetype') }}" disabled />
                        <input type="text" class="form-control" id="type" name="type" value="course" hidden />
                    </div>

                    {{-- <div class="mb-3">
                        <label class="form-label" for="name">{{ trans('ad.url') }}</label>
                        <input type="text" class="form-control" id="url" name="url"/>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">{{ trans('app.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('app.create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

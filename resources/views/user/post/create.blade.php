<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true"  data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="createPostModalLabel">{{ trans('post.create_new_post') }}</h5>
              {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
          </div>
          <div class="modal-body">

                  @csrf
                  <div class="mb-3">
                      <label for="post-ontent" class="form-label">{{ trans('post.content') }}</label>
                      <textarea class="form-control" id="post-content" rows="4" placeholder="{{ trans('post.write_something') }}"></textarea>
                  </div>

                  <div class="mb-3">
                      <label class="form-label">{{ trans('post.upload_video') }}</label>
                      <form class="dropzone" id="post-form" action="{{ route('user.posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="dz-message needsclick col-12">
                            {{ __('lesson.video_dropzone_message') }}
                            <span class="note needsclick">{{ __('lesson.video_dropzone_note') }}</span>
                        </div>
                        <input type="hidden" id="form-content" name="description">
                        <div class="fallback">
                            <input type="file" name="video" class="form-control" accept="video/*">
                        </div>
                    </form>

                  </div>

                  <div class="modal-footer">
                      <button type="button" id="post_cancel_btn" class="btn btn-secondary" data-bs-dismiss="modal">
                          {{ trans('app.close') }}
                      </button>
                      <button type="button" id="post_submit_btn" class="btn btn-primary">
                          {{ trans('post.create') }}
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>

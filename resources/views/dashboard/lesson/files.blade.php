<!-- File Modal -->
<div class="modal fade" id="fileModal{{ $lesson->id }}" tabindex="-1" aria-labelledby="fileModalLabel{{ $lesson->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="fileModalLabel{{ $lesson->id }}">Documents for Lesson {{ $lesson->id }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              @if(count($files) > 0)
                  <div id="fileCarousel{{ $lesson->id }}" class="carousel slide" data-bs-ride="carousel">
                      <div class="carousel-inner">
                          @foreach($files as $index => $file)
                              <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                  <div class="text-center mb-3">
                                      <h6>{{ $file->filename }}</h6>
                                      <a href="{{ $file->url() }}" class="btn btn-primary btn-sm" download>Download</a>
                                  </div>
                                  <embed src="{{ $file->url() }}" type="application/{{ $file->extension }}" width="100%" height="600px" />
                              </div>
                          @endforeach
                      </div>
                      @if(count($files) > 1)
                          <button class="carousel-control-prev" type="button" data-bs-target="#fileCarousel{{ $lesson->id }}" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                          </button>
                          <button class="carousel-control-next" type="button" data-bs-target="#fileCarousel{{ $lesson->id }}" data-bs-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Next</span>
                          </button>
                      @endif
                  </div>
              @else
                  <p>No documents available for this lesson.</p>
              @endif
          </div>
      </div>
  </div>
</div>

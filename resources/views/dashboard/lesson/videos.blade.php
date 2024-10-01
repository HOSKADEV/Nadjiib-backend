  <!-- Video Modal -->
  <div class="modal fade" id="videoModal{{ $lesson->id }}" tabindex="-1" aria-labelledby="videoModalLabel{{ $lesson->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel{{ $lesson->id }}">Videos for Lesson {{ $lesson->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php
                    $videos = $lesson->videos; // Assuming this function exists and returns an array of video objects
                @endphp
                @if(count($videos) > 0)
                    <div id="videoCarousel{{ $lesson->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($videos as $index => $video)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <video class="d-block w-100" controls>
                                        <source src="{{ $video->url() }}" type="video/{{ $video->extension }}">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @endforeach
                        </div>
                        @if(count($videos) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#videoCarousel{{ $lesson->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#videoCarousel{{ $lesson->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                @else
                    <p>No videos available for this lesson.</p>
                @endif
            </div>
        </div>
    </div>
</div>

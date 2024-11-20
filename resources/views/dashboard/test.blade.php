@extends('layouts.blankLayout')

@section('vendor-script')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
@endsection

{{-- @section('vendor-style')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection --}}

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/dropzone.css') }}" type="text/css" />
@endsection

{{-- @section('page-script')
<script src="{{asset('assets/vendor/js/dropzone.js')}}"></script>
@endsection --}}

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Add New Lesson</h2>
                    </div>

                    <div class="card-body">
                        <!-- Course Selection -->
                        <div class="mb-3">
                            <label for="course_id" class="form-label">Select Course</label>
                            <select name="course_id" id="course_id" class="form-select">
                                <option value="">Select a course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Lesson Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Lesson Name</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="form-control" required>
                        </div>

                        <!-- Lesson Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Lesson Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
                        </div>

                        <form class="dropzone" id="video-dropzone" action="{{ url('/lesson/video/upload') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf


                            <input type="hidden" id="lesson_id" name="lesson_id" value="89">


                            <div class="dz-message needsclick">
                                Drop files here or click to upload
                                <span class="note needsclick">(This is just a demo dropzone. Selected files are <span
                                        class="fw-medium">not</span> actually uploaded.)</span>
                            </div>
                            <div class="fallback">
                                <input type="file" name="file" class="form-control" accept="video/*" hidden>
                            </div>

                            <!-- Submit Button -->

                        </form>

                        <div class="my-3">
                            <button type="submit" id="submit" class="btn btn-primary">
                                Create Lesson
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        var e = `<div class="dz-preview dz-file-preview">
  <div class="dz-details">
    <div class="dz-thumbnail">
      <img data-dz-thumbnail>
      <span class="dz-nopreview">No preview</span>
      <div class="dz-success-mark"></div>
      <div class="dz-error-mark"></div>
      <div class="dz-error-message"><span data-dz-errormessage></span></div>
      <div class="progress">
        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
      </div>
    </div>
    <div class="dz-filename" data-dz-name></div>
    <div class="dz-size" data-dz-size></div>
  </div>
  </div>`;

        Dropzone.options.videoDropzone = { // camelized version of the `id`
            previewTemplate: e,
            addRemoveLinks: true,
            uploadMultiple: false,
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2048, // MB
            maxFiles: 1,
            parallelUploads: 5,
            autoProcessQueue: false,
            chunking: true,
            //chunkSize: 5,
            parallelChunkUploads: true,
            init: function() {
                var myDropzone = this;

                // First change the button to actually tell Dropzone to process the queue.
                document.getElementById("submit").addEventListener("click", function(e) {
                    // Make sure that the form isn't actually being sent.
                    e.preventDefault();
                    e.stopPropagation();
                    //$('#form_course_id').val($('#course_id').val());
                    //$('#form_title').val($('#title').val());
                    //$('#form_description').val($('#description').val());
                    myDropzone.processQueue();
                });

                // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
                // of the sending event because uploadMultiple is set to true.
                this.on("sendingmultiple", function() {
                    // Gets triggered when the form is actually being sent.
                    // Hide the success button or the complete form.
                });
                this.on("successmultiple", function(files, response) {
                    // Gets triggered when the files have successfully been sent.
                    // Redirect user or notify of success.
                });
                this.on("errormultiple", function(files, response) {
                    // Gets triggered when there was an error sending the files.
                    // Maybe show form again, and notify user of error
                });
            }
        };
        $(document).ready(function() {

        });
    </script>
@endsection

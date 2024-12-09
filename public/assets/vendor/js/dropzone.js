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

        Dropzone.options.videoForm = { // camelized version of the `id`
            previewTemplate: e,
            addRemoveLinks: true,
            uploadMultiple: false,
            paramName: "video", // The name that will be used to transfer the file
            maxFilesize: 2048, // MB
            maxFiles: 1,
            parallelUploads: 5,
            autoProcessQueue: false,
            chunking: true,
            //chunkSize: 5,
            parallelChunkUploads: true,
            init: function() {
                var myDropzone = this;

                document.getElementById("video_submit_btn").addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });

                this.on("complete", function (file) {
                  if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    $('#video_submit_btn').prop('disabled', true);
                    $('#video_next_btn').prop('disabled', false);
                  }
                });
            }
        };

        Dropzone.options.filesForm = { // camelized version of the `id`
          previewTemplate: e,
          addRemoveLinks: true,
          uploadMultiple: true,
          paramName: "files", // The name that will be used to transfer the file
          maxFilesize: 2048, // MB
          maxFiles: 15,
          parallelUploads: 5,
          autoProcessQueue: false,
          //chunking: true,
          //chunkSize: 5,
          //parallelChunkUploads: true,
          init: function() {
              var myDropzone = this;

              document.getElementById("files_submit_btn").addEventListener("click", function(e) {
                  e.preventDefault();
                  e.stopPropagation();
                  myDropzone.processQueue();
              });

          }
      };


      Dropzone.options.postForm = { // camelized version of the `id`
        previewTemplate: e,
        addRemoveLinks: true,
        uploadMultiple: false,
        paramName: "video", // The name that will be used to transfer the file
        maxFilesize: 2048, // MB
        maxFiles: 1,
        parallelUploads: 5,
        autoProcessQueue: false,
        chunking: true,
        //chunkSize: 5,
        parallelChunkUploads: true,
        init: function() {
            var myDropzone = this;

            document.getElementById("post_submit_btn").addEventListener("click", function(e) {
              $('#post_submit_btn').attr('disabled', true);
              $('#post_cancel_btn').attr('disabled', true);
              $('#form-content').val($('#post-content').val());
                e.preventDefault();
                e.stopPropagation();
                myDropzone.processQueue();
            });

            this.on("complete", function (file) {
              if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                $('#createPostModal').modal('hide');
                location.reload();
              }
            });
        }
    };

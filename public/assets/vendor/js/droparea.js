const dropArea = $('#drop-area');
const fileElem = $('#fileElem');
const imageCropper = $('#image-cropper');
const controls = $('#controls');
const resultDiv = $('#result');
let croppieInstance = null;

// Prevent default drag behaviors
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
  dropArea.on(eventName, preventDefaults);
});

// Highlight drop area when item is dragged over
['dragenter', 'dragover'].forEach(eventName => {
  dropArea.on(eventName, highlight);
});

['dragleave', 'drop'].forEach(eventName => {
  dropArea.on(eventName, unhighlight);
});

// Handle dropped files
dropArea.on('drop', handleDrop);

// Simplified file selection
dropArea.on('click', function (e) {
  // Prevent any potential recursion
  e.stopPropagation();
  fileElem[0].click();
});

fileElem.on('change', function (e) {
  handleFiles(e.target.files);
});

function preventDefaults(e) {
  e.preventDefault();
  e.stopPropagation();
}

function highlight() {
  dropArea.addClass('highlight');
}

function unhighlight() {
  dropArea.removeClass('highlight');
}

function handleDrop(e) {
  const dt = e.originalEvent.dataTransfer;
  const files = dt.files;
  handleFiles(files);
}

function handleFiles(files) {
  if (files.length) {
    const file = files[0];
    if (file.type.match('image.*')) {
      const reader = new FileReader();

      reader.onload = function (e) {
        // Hide drop area, show cropper
        dropArea.hide();

        // Initialize Croppie
        imageCropper.show().croppie({
          viewport: {
            width: 600,
            height: 300,
            type: 'square'
          },
          boundary: {
            width: 700,
            height: 400
          },
          showZoomer: true,
          enableOrientation: true
        });

        // Bind the image
        croppieInstance = imageCropper.data('croppie');
        croppieInstance.bind({
          url: e.target.result
        });

        // Show controls
        controls.show();
      };

      reader.readAsDataURL(file);
    }
  }
}

function resetInterface() {
  // Reset Croppie if it exists
  if (croppieInstance) {
    imageCropper.croppie('destroy');
    croppieInstance = null;
  }

  // Hide controls and result
  controls.hide();
  resultDiv.empty();

  // Reset file input
  fileElem.val('');

  // Show drop area
  dropArea.show();
  imageCropper.hide();
}

// Rotation buttons
$('#rotate-left').on('click', function () {
  croppieInstance.rotate(-90);
});

$('#rotate-right').on('click', function () {
  croppieInstance.rotate(90);
});

$('#cancel-button').on('click', resetInterface);

// Crop button
$('#image_submit_btn').on('click', function () {
    croppieInstance.result({
    type: 'canvas',
    size: 'viewport'
  }).then(function (resp) {
    $.ajax({
      url: 'image/upload',
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: {
          image: resp
      },
      dataType: 'JSON',
      //contentType: false,
      //processData: false,
      success: function(response) {
        $('#image_next_btn').prop('disabled', false);
      },
      error: function(data) {
          var errors = data.responseJSON;
          console.log(errors);
      }


  });
  });
});

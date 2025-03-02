jQuery(document).ready(function ($) {
  const dragDropArea = $("#drag-drop-area");
  const fileInput = $("#yoyo-video-file");
  const form = $("#yoyo-video-upload-form");
  const progressBar = $("#upload-progress");
  const progressIndicator = progressBar.find(".progress");
  const messageDiv = $("#yoyo-video-message");
  const isPaidCheckbox = $("#yoyo-video-paid");
  const priceInputGroup = $("#price-input-group");

  // Toggle price input visibility
  isPaidCheckbox.on("change", function () {
    priceInputGroup.toggle(this.checked);
    $("#yoyo-video-price").prop("required", this.checked);
  });

  // Drag and drop handlers
  dragDropArea.on("dragover dragenter", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).addClass("dragover");
  });

  dragDropArea.on("dragleave dragend drop", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).removeClass("dragover");
  });

  dragDropArea.on("drop", function (e) {
    e.preventDefault();
    const files = e.originalEvent.dataTransfer.files;
    if (files.length) {
      fileInput.prop("files", files);
      updateFileName(files[0].name);
    }
  });

  dragDropArea.on("mousedown", function (event) {
    event.preventDefault();
    fileInput.trigger("click");
  });

  fileInput.on("change", function () {
    if (this.files.length) {
      updateFileName(this.files[0].name);
    }
  });

  function updateFileName(name) {
    dragDropArea.find("p").text(`Selected file: ${name}`);
  }

  // Form submission
  form.on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("action", "yoyo_handle_video_upload");

    // Validate required fields
    const title = $("#yoyo-video-title").val();
    const tags = $("#yoyo-video-tags").val();
    const isPaid = isPaidCheckbox.is(":checked");
    const price = $("#yoyo-video-price").val();

    if (!title) {
      showMessage("Please enter a video title", "error");
      return;
    }

    if (!tags || tags.split(",").length < 3) {
      showMessage("Please enter at least 3 tags separated by commas", "error");
      return;
    }

    if (isPaid && !price) {
      showMessage("Please enter a price for the paid content", "error");
      return;
    }

    // Show progress bar
    progressBar.show();

    $.ajax({
      url: yoyo_ajax.ajaxurl,
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      xhr: function () {
        const xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function (e) {
          if (e.lengthComputable) {
            const percent = (e.loaded / e.total) * 100;
            progressIndicator.css("width", percent + "%");
          }
        });
        return xhr;
      },
      success: function (response) {
        if (response.success) {
          showMessage("Video uploaded successfully!", "success");
          form[0].reset();
          dragDropArea
            .find("p")
            .html(
              'Drag and drop your video file here or <span class="browse-text">Browse</span>'
            );
          priceInputGroup.hide();
        } else {
          showMessage(response.data.message || "Upload failed", "error");
        }
      },
      error: function () {
        showMessage("Upload failed. Please try again.", "error");
      },
      complete: function () {
        progressBar.hide();
        progressIndicator.css("width", "0%");
      },
    });
  });

  function showMessage(message, type) {
    messageDiv
      .removeClass("error success")
      .addClass(type)
      .text(message)
      .show()
      .delay(5000)
      .fadeOut();
  }
});

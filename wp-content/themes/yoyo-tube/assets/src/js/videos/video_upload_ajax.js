jQuery(document).ready(function ($) {
  $("#yoyo-video-upload-form").on("submit", function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("action", "yoyo_handle_video_upload");

    $.ajax({
      url: yoyo_ajax.ajaxurl,
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log(response);
        $("#upload-status").html(response);
      },
    });
  });
});

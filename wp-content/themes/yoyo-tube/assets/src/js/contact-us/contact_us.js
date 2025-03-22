jQuery(document).ready(function ($) {
  // Handle contact form submission
  $("#contact-form").on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("action", "yoyo_contact_form");
    formData.append("nonce", contact_us_params.nonce);

    // Show loading state
    $(".submit-button").addClass("loading");
    $(".button-text").text("Sending...");

    $.ajax({
      url: contact_us_params.ajax_url,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Reset loading state
        $(".submit-button").removeClass("loading");
        $(".button-text").text("Send Message");

        if (response.success) {
          $("#form-response").html(
            '<div class="success-message"><i class="fas fa-check-circle"></i> ' +
              response.data.message +
              "</div>"
          );
          $("#contact-form")[0].reset();
        } else {
          $("#form-response").html(
            '<div class="error-message"><i class="fas fa-exclamation-circle"></i> ' +
              response.data.message +
              "</div>"
          );
        }
      },
      error: function () {
        // Reset loading state
        $(".submit-button").removeClass("loading");
        $(".button-text").text("Send Message");

        $("#form-response").html(
          '<div class="error-message"><i class="fas fa-exclamation-circle"></i> An error occurred. Please try again later.</div>'
        );
      },
    });
  });

  // FAQ accordion functionality
  $(".faq-question").on("click", function () {
    $(this).parent().toggleClass("active");
    $(this).next(".faq-answer").slideToggle(200);
    $(this).find("i").toggleClass("fa-chevron-down fa-chevron-up");
  });
});

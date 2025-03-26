jQuery(document).ready(function ($) {
  function showToast(title, message, type = "info") {
    var toast = $("#yoyo-toast");

    // Update toast content
    toast.find(".toast-title").text(title);
    toast.find(".toast-body").text(message);

    // Add bootstrap class for different types of messages
    var iconClass = "fas fa-info-circle";
    if (type === "success") iconClass = "fas fa-check-circle text-success";
    if (type === "error") iconClass = "fas fa-exclamation-triangle text-danger";

    toast.find(".toast-icon i").attr("class", iconClass);

    // Show toast
    var toastInstance = new bootstrap.Toast(toast[0]);
    toastInstance.show();
  }

  $("#login-form").on("submit", function (e) {
    e.preventDefault();

    var username = $("#login-username").val();
    var password = $("#login-password").val();
    var remember = $("#login-remember").is(":checked");

    $.ajax({
      url: yoyo_auth_ajax.ajaxurl,
      type: "POST",
      data: {
        action: "yoyo_login",
        username: username,
        password: password,
        remember: remember,
        security: yoyo_auth_ajax.security,
      },
      success: function (response) {
        if (response.success) {
          showToast("Success", "Login successful!", "success");
          setTimeout(() => {
            window.location.href = yoyo_auth_ajax.home_url;
          }, 2000);
        } else {
          showToast("Error", "Login failed: " + response.data.message, "error");
        }
      },
      error: function () {
        showToast("Error", "An error occurred. Please try again.", "error");
      },
    });
  });

  $("#signup-form").on("submit", function (e) {
    e.preventDefault();

    var username = $("#signup-username").val();
    var email = $("#signup-email").val();
    var password = $("#signup-password").val();
    var confirmPassword = $("#signup-confirm-password").val();
    var role = $("#signup-role").val();

    if (password !== confirmPassword) {
      showToast("Error", "Passwords do not match.", "error");
      return;
    }

    $.ajax({
      url: yoyo_auth_ajax.ajaxurl,
      type: "POST",
      data: {
        action: "yoyo_signup",
        username: username,
        email: email,
        password: password,
        role: role,
        security: yoyo_auth_ajax.security,
      },
      success: function (response) {
        if (response.success) {
          showToast(
            "Success",
            "Now Login! Signup successful! Your role: " + response.data.role,
            "success"
          );
          setTimeout(() => {
            window.location.href = yoyo_auth_ajax.home_url;
          }, 2000);
        } else {
          showToast(
            "Error",
            "Signup failed: " + response.data.message,
            "error"
          );
        }
      },
      error: function () {
        showToast("Error", "An error occurred. Please try again.", "error");
      },
    });
  });
});

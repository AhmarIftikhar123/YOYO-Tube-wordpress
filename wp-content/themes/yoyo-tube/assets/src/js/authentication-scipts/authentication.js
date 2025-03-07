jQuery(document).ready(function ($) {
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
          alert("Login successful!");
          window.location.href = yoyo_auth_ajax.home_url;
        } else {
          alert("Login failed: " + response.data.message);
        }
      },
      error: function (xhr, response, resonseTxt) {
        console.log(xhr, response, resonseTxt);
        alert("An error occurred. Please try again.");
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
      alert("Passwords do not match.");
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
          alert("Sign up successful! Please log in.");
          $("#login-tab").tab("show");
        } else {
          alert("Sign up failed: " + response.data.message);
        }
      },
      error: function () {
        alert("An error occurred. Please try again.");
      },
    });
  });
});

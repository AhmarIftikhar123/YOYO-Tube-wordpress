/*! For license information please see authentication.js.LICENSE.txt */
(function(){var __webpack_modules__={"./assets/src/js/authentication-scipts/authentication.js":function(){eval('jQuery(document).ready(function ($) {\n  function showToast(title, message) {\n    var type = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "info";\n    var toast = $("#yoyo-toast");\n\n    // Update toast content\n    toast.find(".toast-title").text(title);\n    toast.find(".toast-body").text(message);\n\n    // Add bootstrap class for different types of messages\n    var iconClass = "fas fa-info-circle";\n    if (type === "success") iconClass = "fas fa-check-circle text-success";\n    if (type === "error") iconClass = "fas fa-exclamation-triangle text-danger";\n    toast.find(".toast-icon i").attr("class", iconClass);\n\n    // Show toast\n    var toastInstance = new bootstrap.Toast(toast[0]);\n    toastInstance.show();\n  }\n  $("#login-form").on("submit", function (e) {\n    e.preventDefault();\n    var username = $("#login-username").val();\n    var password = $("#login-password").val();\n    var remember = $("#login-remember").is(":checked");\n    $.ajax({\n      url: yoyo_auth_ajax.ajaxurl,\n      type: "POST",\n      data: {\n        action: "yoyo_login",\n        username: username,\n        password: password,\n        remember: remember,\n        security: yoyo_auth_ajax.security\n      },\n      success: function success(response) {\n        if (response.success) {\n          showToast("Success", "Login successful!", "success");\n          setTimeout(function () {\n            window.location.href = yoyo_auth_ajax.home_url;\n          }, 2000);\n        } else {\n          showToast("Error", "Login failed: " + response.data.message, "error");\n        }\n      },\n      error: function error() {\n        showToast("Error", "An error occurred. Please try again.", "error");\n      }\n    });\n  });\n  $("#signup-form").on("submit", function (e) {\n    e.preventDefault();\n    var username = $("#signup-username").val();\n    var email = $("#signup-email").val();\n    var password = $("#signup-password").val();\n    var confirmPassword = $("#signup-confirm-password").val();\n    var role = $("#signup-role").val();\n    if (password !== confirmPassword) {\n      showToast("Error", "Passwords do not match.", "error");\n      return;\n    }\n    $.ajax({\n      url: yoyo_auth_ajax.ajaxurl,\n      type: "POST",\n      data: {\n        action: "yoyo_signup",\n        username: username,\n        email: email,\n        password: password,\n        role: role,\n        security: yoyo_auth_ajax.security\n      },\n      success: function success(response) {\n        if (response.success) {\n          showToast("Success", "Now Login! Signup successful! Your role: " + response.data.role, "success");\n          setTimeout(function () {\n            window.location.href = yoyo_auth_ajax.home_url;\n          }, 2000);\n        } else {\n          showToast("Error", "Signup failed: " + response.data.message, "error");\n        }\n      },\n      error: function error() {\n        showToast("Error", "An error occurred. Please try again.", "error");\n      }\n    });\n  });\n});\n\n//# sourceURL=webpack://yoyo-tube/./assets/src/js/authentication-scipts/authentication.js?')}},__webpack_exports__={};__webpack_modules__["./assets/src/js/authentication-scipts/authentication.js"]()})();
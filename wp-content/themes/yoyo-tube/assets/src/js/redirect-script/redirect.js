jQuery(document).ready(function ($) {
  // Pass $ inside the function
  if (jQuery("#redirectMessage").length) {
    setTimeout(function () {
      window.location.href = yoyo_ajax.home_url; // Redirect URL from PHP
    }, 1000);
  }
});

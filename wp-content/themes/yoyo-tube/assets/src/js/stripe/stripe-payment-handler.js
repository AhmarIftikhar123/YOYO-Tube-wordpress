jQuery(document).ready(function ($) {
  const stripe = Stripe(
    "pk_test_51Q5gn6EQVKGjbQGAtUA9x0HT3lBThNmARbHCutAi87uNtZ5fWGL8e1C9AnAS2W7nNGKE2VLj3yUdKlFu5ydg4v8u00I7kJQ9kD"
  ); // Stripe public key
  const elements = stripe.elements();
  const style = {
    base: {
      color: "#333333",
      fontSize: "16px",
      "::placeholder": { color: "rgba(0, 0, 0, 0.6)" },
      backgroundColor: "#ffffff",
      padding: "10px",
      border: "1px solid #8a2be2",
      borderRadius: "5px",
    },
    invalid: {
      color: "#ff4d4d",
    },
  };
  const card = elements.create("card", { style: style });
  card.mount("#card-element");

  // Toast notification function
  function showToast(message, type = "info") {
    // Set icon based on type
    let icon = "fa-info-circle";
    let title = "Information";

    if (type === "success") {
      icon = "fa-check-circle";
      title = "Success";
    } else if (type === "error") {
      icon = "fa-exclamation-circle";
      title = "Error";
    } else if (type === "warning") {
      icon = "fa-exclamation-triangle";
      title = "Warning";
    }

    // Update toast content
    const toast = $("#yoyo-toast");
    toast.removeClass("success error warning info").addClass(type);
    toast
      .find(".toast-icon i")
      .removeClass()
      .addClass("fas " + icon);
    toast.find(".toast-title").text(title);
    toast.find(".toast-body").text(message);

    // Show toast
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
  }

  card.addEventListener("change", function (event) {
    if (event.error) {
      showToast(event.error.message, "error");
    }
  });

  $("#stripe-payment-form").on("submit", function (event) {
    event.preventDefault();
    $("#submit-payment").prop("disabled", true).text("Processing...");

    stripe.createToken(card).then(function (result) {
      if (result.error) {
        showToast(result.error.message, "error");
        $("#submit-payment").prop("disabled", false).text("Pay Now");
      } else {
        const data = {
          action: "handle_stripe_payment",
          stripeToken: result.token.id,
          video_id: $("#video_id").val(),
        };
        // Send token via AJAX
        $.ajax({
          url: yoyo_stripe_ajax.ajaxurl, // endpoint
          method: "POST",
          data: data,
          success: function (response) {
            if (response.success) {
              showToast(
                response.data.message || "Payment successful!",
                "success"
              );
              setTimeout(function () {
                window.location.reload();
              }, 2000);
            } else {
              showToast(response.data.message || "Payment failed.", "error");
            }
          },
          error: function (xhr, statusText, error) {
            let errorMessage = "An error occurred. Please try again.";
            if (xhr.responseJSON && xhr.responseJSON.data.message) {
              errorMessage = xhr.responseJSON.data.message;
            }
            showToast(errorMessage, xhr.status);
          },
          complete: function () {
            $("#submit-payment").prop("disabled", false).text("Pay Now");
          },
        });
      }
    });
  });
});

jQuery(document).ready(($) => {
  // Find all restricted content messages
  const restrictedMessages = $(".restricted-content-message");

  if (restrictedMessages.length) {
    restrictedMessages.each(function () {
      const message = $(this);
      const countdownEl = message.find(".countdown");
      const progressBar = message.find(".progress-bar");
      const redirectUrl = message.data("redirect");
      let timeLeft = 5; // 5 seconds countdown

      // Start the progress bar animation
      setTimeout(() => {
        progressBar.addClass("active");
      }, 100);

      // Update countdown every second
      const countdownInterval = setInterval(() => {
        timeLeft--;
        countdownEl.text(timeLeft);

        if (timeLeft <= 0) {
          clearInterval(countdownInterval);

          // Redirect to login page
          window.location.href = redirectUrl;
        }
      }, 1000);

      // Handle manual redirect button click
      message.find(".auth-button").on("click", (e) => {
        e.preventDefault();
        clearInterval(countdownInterval);
        window.location.href = redirectUrl;
      });
    });
  }
});

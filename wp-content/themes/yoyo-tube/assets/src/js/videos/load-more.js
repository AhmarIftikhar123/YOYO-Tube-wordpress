jQuery(document).ready(($) => {
  const loadMoreBtn = $("#load-more-btn");
  const videoGrid = $("#video-grid");

  if (loadMoreBtn.length) {
    loadMoreBtn.on("click", function () {
      const button = $(this);
      const currentPage = Number.parseInt(button.data("page"));
      const maxPages = Number.parseInt(button.data("max"));
      const nextPage = currentPage + 1;

      // Show loading spinner
      button.addClass("loading");
      button.find("span").hide();
      button.find("i").show();

      // AJAX request to load more posts
      $.ajax({
        url: yoyo_ajax_params.ajax_url,
        type: "POST",
        data: {
          action: "load_more_videos",
          nonce: yoyo_ajax_params.nonce,
          page: nextPage,
        },
        success: (response) => {
          if (response.success) {
            // Append new posts
            videoGrid.append(response.data.html);

            // Update button data attribute
            button.data("page", nextPage);

            // Initialize any scripts for the new content
            if (typeof initVideoItems === "function") {
              initVideoItems();
            }

            // Hide button if we've reached the max pages
            if (nextPage >= maxPages) {
              button.fadeOut();
            }
          } else {
            console.error("Error loading more videos:", response.data.message);
          }
        },
        error: (xhr, status, error) => {
          console.error("AJAX error:", error);
        },
        complete: () => {
          // Hide loading spinner
          button.removeClass("loading");
          button.find("span").show();
          button.find("i").hide();
        },
      });
    });
  }

  // Function to initialize video items (called on page load and after loading more)
  function initVideoItems() {
    // Add classes to video items based on price
    const videoItems = document.querySelectorAll(
      ".video-item:not(.initialized)"
    );

    videoItems.forEach((item) => {
      const priceElement = item.querySelector(".video-price");
      if (priceElement) {
        if (priceElement.textContent.includes("$")) {
          item.classList.add("is-paid");
          priceElement.classList.add("paid-price");

          // Make price clickable to purchase
          priceElement.addEventListener("click", function () {
            const watchButton = this.closest(".video-item").querySelector(
              ".video-link"
            );
            if (watchButton) {
              watchButton.click();
            }
          });
        } else {
          item.classList.add("is-free");
          priceElement.classList.add("free-price");
        }
      }

      // Make thumbnails clickable
      const thumbnail = item.querySelector(".video-thumbnail");
      if (thumbnail) {
        thumbnail.addEventListener("click", function () {
          const watchButton = this.closest(".video-item").querySelector(
            ".video-link"
          );
          if (watchButton) {
            watchButton.click();
          }
        });
      }

      // Mark as initialized
      item.classList.add("initialized");
    });
  }

  // Initialize video items on page load
  initVideoItems();
});

/**
 * YOYO Tube Search Functionality
 */
import $ from "jquery";

jQuery(document).ready(() => {
  // Elements
  const searchToggle = $(".search-toggle");
  const searchForm = $(".search-form");
  const searchInput = $(".search-input");
  const searchClose = $(".search-close");
  const searchResults = $(".search-results-container");
  const searchResultsList = $(".search-results-list");
  const closeResults = $(".close-results");
  const searchLoading = $(".search-loading");

  // Toggle search form
  searchToggle.on("click", () => {
    searchForm.addClass("active");
    searchClose.addClass("active");
    searchInput.trigger("focus");
  });

  // Close search form
  searchClose.on("click", () => {
    searchForm.removeClass("active");
    searchClose.removeClass("active");
    searchResults.removeClass("active");
  });

  // Close search results
  closeResults.on("click", () => {
    searchResults.removeClass("active");
  });

  // Handle search form submission
  searchForm.on("submit", (e) => {
    e.preventDefault();
    const searchTerm = searchInput.val().trim();

    if (searchTerm.length < 2) {
      return;
    }

    // Show loading indicator
    searchResults.addClass("active");
    searchResultsList.hide();
    searchLoading.addClass("active");

    // AJAX request to search
    $.ajax({
      url: yoyo_search_params.ajax_url,
      type: "POST",
      data: {
        action: "yoyo_ajax_search",
        nonce: yoyo_search_params.nonce,
        search: searchTerm,
      },
      success: (response) => {
        // Hide loading indicator
        searchLoading.removeClass("active");

        if (response.success) {
          // Show results
          searchResultsList.html(response.data.html);
          searchResultsList.show();

          // Update count in header
          $(".results-count").text(response.data.count);

          // Show/hide view all link
          if (response.data.count > 5) {
            $(".search-results-footer").show();
            $(".view-all-results").attr("href", response.data.search_url);
          } else {
            $(".search-results-footer").hide();
          }
        } else {
          // Show no results message
          searchResultsList.html(
            '<div class="no-results">' +
              '<i class="fas fa-search"></i>' +
              "<h4>No results found</h4>" +
              "<p>Try different keywords or check spelling</p>" +
              "</div>"
          );
          searchResultsList.show();
          $(".search-results-footer").hide();
        }
      },
      error: () => {
        // Hide loading indicator
        searchLoading.removeClass("active");

        // Show error message
        searchResultsList.html(
          '<div class="no-results">' +
            '<i class="fas fa-exclamation-circle"></i>' +
            "<h4>Something went wrong</h4>" +
            "<p>Please try again later</p>" +
            "</div>"
        );
        searchResultsList.show();
        $(".search-results-footer").hide();
      },
    });
  });

  // Handle search input (live search)
  let searchTimeout;
  searchInput.on("input", function () {
    const searchTerm = $(this).val().trim();

    // Clear previous timeout
    clearTimeout(searchTimeout);

    // Don't search for short terms
    if (searchTerm.length < 2) {
      searchResults.removeClass("active");
      return;
    }

    // Set timeout for search (to avoid too many requests)
    searchTimeout = setTimeout(() => {
      // Trigger form submission
      searchForm.trigger("submit");
    }, 500);
  });

  // Close search results when clicking outside
  $(document).on("click", (e) => {
    if (!$(e.target).closest(".search-container").length) {
      searchResults.removeClass("active");

      // On mobile, also close the search form
      if (window.innerWidth < 992) {
        searchForm.removeClass("active");
        searchClose.removeClass("active");
      }
    }
  });

  // Prevent clicks inside search results from closing it
  searchResults.on("click", (e) => {
    e.stopPropagation();
  });
});

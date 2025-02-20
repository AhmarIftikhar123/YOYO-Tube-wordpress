(function ($) {
  /**
   * Class Loadmore.
   */
  class LoadMore {
    /**
     * Constructor.
     */
    constructor() {
      this.ajaxUrl = siteConfig?.ajaxURL ?? "";
      this.ajaxNonce = siteConfig?.ajax_nonce ?? "";
      this.loadMoreBtn = $("#single-load-more");
      this.loadingTextEl = $("#loading-text");
      this.isRequestProcessing = false;

      this.init();
    }

    init() {
      if (!this.loadMoreBtn.length) {
        return;
      }
      this.totalPagesCount = this.loadMoreBtn.data("max-pages"); // Use the button's data attribute

      // Bind the method to the class instance
      this.loadMoreBtn.on("click", this.handleLoadMorePosts.bind(this));
    }

    /**
     * Load more posts.
     *
     * 1. Make an AJAX request, by incrementing the page no. by one on each request.
     * 2. Append new/more posts to the existing content.
     * 3. If the response is 0 (which means no more posts available), remove the load-more button from DOM.
     * Once the load-more button gets removed, the IntersectionObserverAPI callback will not be triggered, which means
     * there will be no further AJAX request since there won't be any more posts available.
     *
     * @return null
     */
    handleLoadMorePosts() {
      // Get page no from data attribute of load-more button.
      const page = this.loadMoreBtn.data("page");
      if (!page || this.isRequestProcessing) {
        return null;
      }

      const nextPage = parseInt(page) + 1; // Increment page count by one.
      this.isRequestProcessing = true;
      this.toggleLoading(true); // Show loading state

      $.ajax({
        url: this.ajaxUrl,
        type: "post",
        data: {
          page: page,
          action: "load_more",
          ajax_nonce: this.ajaxNonce,
        },
        beforeSend: () => {
          this.toggleLoading(true); // Show loading state before sending the request
        },
        success: (response) => {
          if (response.length !== 0) {
            // Update the DATA attribute on the Page.
            this.loadMoreBtn.data("page", nextPage);
            // Append the data
            $("#load-more-content").append(response);
            this.removeLoadMoreIfOnLastPage(nextPage);
          } else {
            this.loadMoreBtn.remove(); // Remove the button if no more posts are available
          }
        },
        error: (response) => {
          console.warn("Error loading more posts:", response);
        },
        complete: () => {
          this.toggleLoading(false); // Hide loading state after the request is complete
          this.isRequestProcessing = false; // Reset the request processing flag
        },
      });
    }

    /**
     * Remove Load more Button If on last page.
     *
     * @param {int} nextPage New Page.
     */
    removeLoadMoreIfOnLastPage(nextPage) {
      if (nextPage >= this.totalPagesCount) {
        this.loadMoreBtn.remove();
      }
    }

    /**
     * Toggle the loading state.
     *
     * @param {boolean} isLoading Whether the loading state should be shown.
     */
    toggleLoading(isLoading) {
      if (isLoading) {
        this.loadingTextEl.removeClass("d-none"); // Show loading text
        this.loadMoreBtn.prop("disabled", true); // Disable the button
      } else {
        this.loadingTextEl.addClass("d-none"); // Hide loading text
        this.loadMoreBtn.prop("disabled", false); // Enable the button
      }
    }
  }

  new LoadMore();
})(jQuery);

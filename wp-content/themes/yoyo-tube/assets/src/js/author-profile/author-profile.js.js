jQuery(document).ready(($) => {
  // Initialize tabs if using direct links
  const urlParams = new URLSearchParams(window.location.search);
  const tab = urlParams.get("tab");

  if (tab) {
    // Add active class to the selected tab
    $(".author-tabs .nav-link").removeClass("active");
    $(`#${tab}-tab`).addClass("active");

    // Show the selected tab content
    $(".tab-pane").removeClass("show active");
    $(`#${tab}`).addClass("show active");
  }

  // Handle tab clicks for browsers without JS navigation
  $(".author-tabs .nav-link").on("click", (e) => {
    // The href attribute already contains the correct URL with tab parameter
    // Let the default behavior handle the navigation
  });

  // Add animation to newly visible elements when tab changes
  if (window.history && window.history.pushState) {
    // When URL changes
    $(window).on("popstate", () => {
      animateTabContent();
    });

    // On page load
    animateTabContent();
  }

  function animateTabContent() {
    const activeTab = $(".tab-pane.active");

    if (activeTab.length) {
      // Add animation classes to grid items or comments
      if (activeTab.find(".video-grid").length) {
        const items = activeTab.find(".video-item");
        items.each(function (index) {
          const item = $(this);
          setTimeout(() => {
            item.addClass("animated");
          }, index * 100);
        });
      } else if (activeTab.find(".author-comments-list").length) {
        const comments = activeTab.find(".author-comment-item");
        comments.each(function (index) {
          const comment = $(this);
          setTimeout(() => {
            comment.addClass("animated");
          }, index * 100);
        });
      }
    }
  }
});

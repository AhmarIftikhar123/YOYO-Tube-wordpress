(function ($) {
  class SlickCarousel {
    constructor() {
      // Check if the carousel element exists
      if ($(".carousel").length) {
        $(".carousel").slick({
          autoplay: true,
          autoplaySpeed: 1000, // Adjusted to 3 seconds
          slidesToShow: 3, // Default number of slides to show
          slidesToScroll: 1, // Default number of slides to scroll
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true,
              },
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
              },
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              },
            },
          ],
        });
      } else {
        console.warn("No carousel element found.");
      }
    }
  }

  // Initialize the carousel
  new SlickCarousel();
})(jQuery);
/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ 309:
/***/ (function() {

(function ($) {
  class SlickCarousel {
    constructor() {
      // Check if the carousel element exists
      if ($(".carousel").length) {
        $(".carousel").slick({
          autoplay: true,
          autoplaySpeed: 1000,
          // Adjusted to 3 seconds
          slidesToShow: 3,
          // Default number of slides to show
          slidesToScroll: 1,
          // Default number of slides to scroll
          responsive: [{
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
              infinite: true,
              dots: true
            }
          }, {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          }, {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }]
        });
      } else {
        console.warn("No carousel element found.");
      }
    }
  }

  // Initialize the carousel
  new SlickCarousel();
})(jQuery);

/***/ }),

/***/ 121:
/***/ (function() {

(function ($) {
  /**
   * Class Loadmore.
   */
  class LoadMore {
    /**
     * Contructor.
     */
    constructor() {
      this.ajaxUrl = siteConfig?.ajaxURL ?? "";
      this.ajaxNonce = siteConfig?.ajax_nonce ?? "";
      this.loadMoreBtn = $("#load-more");
      this.loadingTextEl = $("#loading-text");
      this.isRequestProcessing = false;
      this.options = {
        root: null,
        rootMargin: "0px",
        threshold: 1.0 // 1.0 means set isIntersecting to true when element comes in 100% view.
      };
      this.init();
    }
    init() {
      if (!this.loadMoreBtn.length) {
        return;
      }
      this.totalPagesCount = $("#post-pagination").data("max-pages");
      /**
       * Add the IntersectionObserver api, and listen to the load more intersection status.
       * so that intersectionObserverCallback gets called if the element intersection status changes.
       *
       * @type {IntersectionObserver}
       */
      const observer = new IntersectionObserver(entries => this.intersectionObserverCallback(entries), this.options);
      observer.observe(this.loadMoreBtn[0]);
    }

    /**
     * Gets called on initial render with status 'isIntersecting' as false and then
     * everytime element intersection status changes.
     *
     * @param {array} entries No of elements under observation.
     *
     */
    intersectionObserverCallback(entries) {
      // array of observing elements

      // The logic is apply for each entry ( in this case it's just one loadmore button )
      entries.forEach(entry => {
        // If load more button in view.
        if (entry?.isIntersecting) {
          this.handleLoadMorePosts();
        }
      });
    }

    /**
     * Load more posts.
     *
     * 1.Make an ajax request, by incrementing the page no. by one on each request.
     * 2.Append new/more posts to the existing content.
     * 3.If the response is 0 ( which means no more posts available ), remove the load-more button from DOM.
     * Once the load-more button gets removed, the IntersectionObserverAPI callback will not be triggered, which means
     * there will be no further ajax request since there won't be any more posts available.
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
      $.ajax({
        url: this.ajaxUrl,
        type: "post",
        data: {
          page: page,
          action: "load_more",
          ajax_nonce: this.ajaxNonce
        },
        success: response => {
          if (response.length !== 0) {
            // Update the DATA attribute on the Page.
            this.loadMoreBtn.data("page", nextPage);
            //append the data
            $("#load-more-content").append(response);
            this.removeLoadMoreIfOnLastPage(nextPage);
            this.isRequestProcessing = false;
          } else {
            this.loadMoreBtn.remove();
          }
        },
        error: response => {
          console.warn(response);
          // this.isRequestProcessing = false;
        }
      });
    }

    /**
     * Remove Load more Button If on last page.
     *
     * @param {int} nextPage New Page.
     */
    removeLoadMoreIfOnLastPage(nextPage) {
      if (nextPage + 1 > this.totalPagesCount) {
        this.loadMoreBtn.remove();
      }
    }
  }
  new LoadMore();
})(jQuery);

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/************************************************************************/
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
!function() {
"use strict";
/* harmony import */ var _carousel_index__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(309);
/* harmony import */ var _carousel_index__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_carousel_index__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _posts_loadmore__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(121);
/* harmony import */ var _posts_loadmore__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_posts_loadmore__WEBPACK_IMPORTED_MODULE_1__);
// import './clock';

// scss files

// Images


// Carousel

// LoadMore posts 

}();
/******/ })()
;
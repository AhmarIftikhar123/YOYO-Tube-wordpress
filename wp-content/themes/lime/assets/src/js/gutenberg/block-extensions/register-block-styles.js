/**
 * Registers block styles for the Gutenberg editor.
 *
 * @since 1.0.0
 */
import { registerBlockStyle, unregisterBlockStyle } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
/**
 * List of block style options for the core/button block.
 */
const layoutStyleButtons = [
  {
    name: "layout-border-blue-fill",
    label: __("Blue outline", "YOYO-Tube"),
  },
  {
    name: "layout-border-white-no-fill",
    label: __("White outline - to be used with dark background", "YOYO-Tube"),
  },
];

/**
 * List of block style options for the core/paragraph block.
 */
const layoutStyleQuote = [
  {
    name: "layout-dark-background",
    label: __("Quote Dark background", "YOYO-Tube"),
  },
];

/**
 * Registers block styles for the Gutenberg editor.
 *
 * @since 1.0.0
 */
const registerBlockStyles = () => {
  // Register block styles for the core/button block
  layoutStyleButtons.forEach((style) => {
    registerBlockStyle("core/button", style);
  });

  // Register block styles for the core/paragraph block
  layoutStyleQuote.forEach((style) => {
    registerBlockStyle("core/paragraph", style);
  });
};
const unRegisterBlockStyles = () => {
  unregisterBlockStyle("core/button", "fill");
};

// Run the registerBlockStyles function when the DOM is ready
wp.domReady(() => {
  registerBlockStyles();
  unRegisterBlockStyles();
});

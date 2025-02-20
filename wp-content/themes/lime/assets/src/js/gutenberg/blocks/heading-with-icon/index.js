import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText } from "@wordpress/block-editor";
import { getIconComponent } from "./icons-map";

import Edit from "./edit";

registerBlockType("yoyo-blocks/heading-with-icon", {
  title: __("Heading with Icon", "YOYO-Tube"),
  icon: "admin-customizer",
  category: "Heading_Block", // Use a valid WordPress block category
  description: __("This is a heading with icon.", "YOYO-Tube"),
  example: {},

  attributes: {
    option: {
      type: "string",
      default: "DOS",
    },
    content: {
      type: "string",
      source: "html",
      selector: "h4",
      default: __("DOS", "YOYO-Tube"),
    },
  },

  edit: Edit,

  save({ attributes: { content, option } }) {
    const HeadingIcon = getIconComponent(option);

    console.log("save", content); // Debugging output

    return (
      <div className="yoyo-icon-heading__heading">
        {/* Icon placeholder */}
        <span className="d-grid">
          <HeadingIcon />
        </span>
        <RichText.Content
          tagName="h4"
          className="yoyo-icon-heading"
          value={content}
        />
      </div>
    );
  },
});

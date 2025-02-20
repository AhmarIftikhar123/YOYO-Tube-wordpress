import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { InnerBlocks } from "@wordpress/block-editor";

import Edit from "./edit";

registerBlockType("yoyo-blocks/dos-and-donts", {
  title: __("Dos and Dont's", "YOYO-Tube"),
  icon: "editor-table",
  category: "Heading_Block", // Use a valid WordPress block category
  description: __("Add heading and text", "YOYO-Tube"),
  example: {},

  edit: Edit,

  save() {
    return (
      <div className="yoyo-dos-and-donts">
        <InnerBlocks.Content />
      </div>
    );
  },
});

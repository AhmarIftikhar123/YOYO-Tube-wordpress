import { InnerBlocks } from "@wordpress/block-editor";
import innerBlockColumns from "./template";

// Define which blocks are allowed inside InnerBlocks
const ALLOWED_BLOCKS = [
  "core/group",
  "core/columns",
  "core/column",
  "core/list",
  "yoyo-blocks/heading-with-icon",
];

// Define the default block structure
const TEMPLATE = [
  [
    "core/group", // Use a core/group block
    {
      className: "yoyo-dos-and-donts__group", // Add a custom class
      backgroundColor: "vivid-red",
    },
    innerBlockColumns, // Use the blockColumns structure
  ],
];

// The Edit component
const Edit = () => {
  return (
    <div className="yoyo-dos-and-donts">
      <InnerBlocks
        allowedBlocks={ALLOWED_BLOCKS} // Allow specific blocks
        templateLock={false} // Lock the template to prevent changes
        template={TEMPLATE} // Use the defined template
      />
    </div>
  );
};

export default Edit;

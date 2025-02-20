/**
 * @typedef {import('@wordpress/element').WPElement} WPElement
 */

import { RichText, InspectorControls } from "@wordpress/block-editor";
import { getIconComponent } from "./icons-map";
import { RadioControl, PanelBody } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
const Edit = ({ attributes, setAttributes }) => {
  const { content, option } = attributes;
  const HeadingIcon = getIconComponent(option);

  return (
    <div className="yoyo-icon-heading">
      <span className="d-grid">
        <HeadingIcon />
      </span>
      <RichText
        tagName="h4"
        className="yoyo-icon-heading"
        value={content}
        onChange={(newContent) => setAttributes({ content: newContent })}
        placeholder={__("Heading...", "YOYO-Tube")} // Translation text domain
      />
      <InspectorControls>
        <PanelBody title={__("Icon", "YOYO-Tube")}>
          <RadioControl
            label={__("Select The Icon", "YOYO-Tube")}
            help={__("Control The Icon Selection", "YOYO-Tube")}
            options={[
              { label: __("DOS", "YOYO-Tube"), value: "DOS" },
              { label: __("DONTS", "YOYO-Tube"), value: "DONTS" },
            ]}
            selected={attributes.option}
            onChange={(value) => setAttributes({ option: value })}
          />
        </PanelBody>
      </InspectorControls>
    </div>
  );
};

export default Edit;

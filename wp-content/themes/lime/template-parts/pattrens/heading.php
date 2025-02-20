<?php
/**
 * Template part for displaying block pattrens
 *
 * @package YOYO-Tube
 */
$bg_img_url = esc_url(TEMPLATE_URI . '/dist/images/cover.jpg');
?>

<!-- wp:cover {"url":"<?= "http://localhost:8001/wp-content/uploads/2025/01/Limedesign-1.png" ?? esc_attr($bg_img_url) ?>","id":117,"dimRatio":80,"customOverlayColor":"#465142","isUserOverlayColor":false,"layout":{"type":"constrained"}} -->
<div class="wp-block-cover">
          <span aria-hidden="true" class="wp-block-cover__background has-background-dim-80 has-background-dim"
                    style="background-color:#465142"></span>
          <img class="wp-block-cover__image-background wp-image-117" alt=""
                    src="<?= "http://localhost:8001/wp-content/uploads/2025/01/Limedesign-1.png" ?? esc_attr($bg_img_url) ?>"
                    data-object-fit="cover" />
          <div class="wp-block-cover__inner-container">
                    <!-- wp:paragraph {"align":"center","placeholder":"Write title…","style":{"elements":{"link":{"color":{"text":"var:preset|color|black"}}}},"textColor":"black","fontSize":"x-large"} -->
                    <p
                              class="has-text-align-center has-black-color has-text-color has-link-color has-x-large-font-size">
                              The Heading of the Post.</p>
                    <!-- /wp:paragraph -->
                    <!-- wp:paragraph {"align":"center"} -->
                    <p class="has-text-align-center">The is the content of the Post.</p>
                    <!-- /wp:paragraph -->
                    <!-- wp:buttons {"align":"full","layout":{"type":"flex","justifyContent":"center"}} -->
                    <div class="wp-block-buttons alignfull">
                              <!-- wp:button {"textAlign":"center"} -->
                              <div class="wp-block-button">
                                        <a class="wp-block-button__link has-text-align-center wp-element-button">Read
                                                  More</a>
                              </div>
                              <!-- /wp:button -->
                    </div>
                    <!-- /wp:buttons -->
          </div>
</div>
<!-- /wp:cover -->
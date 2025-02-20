<?php
/**
 * Entry Content Template
 *
 * This template is used inside the WordPress Loop to display the content
 * for posts. It handles both single post views and other post views
 * (like archives or blog lists).
 * 
 * @package YOYO-Tube
 */

// Import the Template_tags class for helper functions.
use Inc\Helpers\Template_tags;

// Instantiate the Template_tags class.
$template_tags = new Template_tags();
?>

<!-- Entry content container -->
<div class="entry-content">
          <?php if (is_single()): ?>
                    <!-- Check if the current view is a single post page -->
                    <?php
                    the_content(
                              sprintf(
                                        // Use wp_kses to sanitize the output and allow specific HTML tags
                                        wp_kses(
                                                  __(
                                                            // 'Continue reading' message with the post title dynamically inserted
                                                            'Continue reading %s <span class="meta-nav">&rarr;</span>',
                                                            'YOYO-Tube'
                                                  ),
                                                  [
                                                            "span" => ["class" => []] // Allow only <span> tags with a "class" attribute
                                                  ]
                                        ),
                                        // Append the post title in a visually hidden span for screen readers
                                        the_title('<span class="screen-reader-text">', '</span>', false)
                              )
                    );
                    ?>
          <?php else: ?>
                    <!-- If not a single post, display a "Read More" button -->
                    <?php echo $template_tags->yoyo_exert_more("Read More →"); ?>
          <?php endif; ?>

          <?php if (is_single()) {
                    wp_link_pages(['before' => '<div class="page-links">' . __('Pages:', 'YOYO-Tube'), 'after' => '</div>']);
          } ?>
</div>
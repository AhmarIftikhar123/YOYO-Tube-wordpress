<?php
/**
 * Template part for displaying posts in the header
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package YOYO-Tube
 */

// Retrieve the video URL from post meta
$get_thumbnail_url = get_post_meta(get_the_ID(), 'thumbnail_url', true);

$thumbnail_url =  $get_thumbnail_url ? $get_thumbnail_url  : "https://placehold.co/600x500?text=Don%27t%20Have%20Thumbnail";
// Get the page title and sanitize it
$page_title = wp_kses_post(get_the_title());

// Determine if the heading should be hidden (this can be customized as needed)
$is_heading_hidden = ''; // You can set this to 'hidden' or any other attribute if needed

// Calculate the length of the title
$title_length = strlen($page_title);

// Define the maximum length for the title before truncation
$max_title_length = 25;
?>

<!-- Video Thumbnail Section -->
<div class="video-thumbnail">
<img src="<?php echo esc_url($thumbnail_url); ?>" alt="">
</div>

<?php
// Determine the heading tag based on the context (single post/page or archive)
if (is_single() || is_page()) {
          // Use h1 for single posts or pages
          $heading = sprintf(
                    '<h1 class="video-gallery-title"%s>%s</h1>',
                    $is_heading_hidden ? ' ' . esc_attr($is_heading_hidden) : '',
                    esc_html($title_length > $max_title_length ? substr($page_title, 0, $max_title_length) . '...' : $page_title)
          );
} else {
          // Use h2 for other contexts (e.g., archives, categories)
          $heading = sprintf(
                    '<h2 class="video-gallery-title">%s</h2>',
                    esc_html($title_length > $max_title_length ? substr($page_title, 0, $max_title_length) . '...' : $page_title)
          );
}

// Output the heading
echo $heading;
?>
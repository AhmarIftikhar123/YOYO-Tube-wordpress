<?php
/**
 * Template Name: Video Gallery
 *
 * This is the template for displaying all videos.
 *
 * @package YOYO-Tube
 */

get_header();

// Get 5 most recent videos
$args = array(
    'post_type' => 'yoyo_videos',
    'posts_per_page' => 5,
    'orderby' => 'date',
    'order' => 'DESC',
);

$video_query = new WP_Query($args);

// Display video gallery
?>

<div class="video-gallery-container">
    <div class="video-grid">
        <?php if ($video_query->have_posts()): ?>

            <?php while ($video_query->have_posts()):
                $video_query->the_post(); ?>

                <?php get_template_part("template-parts/content"); ?>

            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>

        <?php else: ?>

            <?php get_template_part("template-parts/content-none"); ?>

        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>
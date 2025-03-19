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
    'paged' => 1,
);

$video_query = new WP_Query($args);
$total_posts = $video_query->found_posts;
$posts_per_page = 5;
$max_pages = ceil($total_posts / $posts_per_page);
?>

<div class="video-gallery-container">
    <div class="video-grid" id="video-grid">
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
    
    <?php  if ($total_posts > $posts_per_page): ?>
        <div class="load-more-container">
            <button id="load-more-btn" class="load-more-btn" data-page="1" data-max="<?php echo $max_pages; ?>">
                <span>Load More</span>
                <i class="fas fa-spinner fa-spin" style="display: none;"></i>
            </button>
        </div>
    <?php  endif; ?>
</div>

<?php get_footer(); ?>


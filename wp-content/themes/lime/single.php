<?php
/**
 * Single template
 *
 * @package YOYO-Tube
 */
use Inc\Helpers\Template_tags;

$template_tags = new Template_tags();
?>

<?php get_header(); ?>

<main id="content" class="container">
    <div class="row">
        <?php if (have_posts()) : ?>
            <div class="col-md-8 col-lg-8 col-sm-12">
                <!-- If Post Found, Get All Posts Content -->
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part("template-parts/content"); ?>
                <?php endwhile; ?>

                <!-- Post Navigation -->
                <div class="container">
                    <div class="pre_link"><?php previous_post_link(); ?></div>
                    <div class="next_link"><?php next_post_link(); ?></div>
                </div>

                <!-- Pagination -->
                <?= $template_tags->yoyo_pagination(); ?>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4 col-lg-4 col-sm-12">
                <?php get_sidebar("Sidebar"); ?>
            </div>
        <?php else : ?>
            <!-- No Posts Found -->
            <div class="col-12">
                <p><?php get_template_part("template-parts/content-none"); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Load More Posts Shortcode -->
    <?= do_shortcode('[single_post_listings]'); ?>
    <?php comments_template(); ?>
</main>

<?php get_footer(); ?>
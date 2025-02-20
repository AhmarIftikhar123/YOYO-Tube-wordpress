<?php

use Inc\Helpers\Template_tags;
/**
 * The template for displaying search results.
 */

get_header(); // Include the header template

global $wp_query; // Access the global WP_Query object
$template_tags = new Template_tags();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php if ($wp_query->have_posts()) : ?>
            <!-- Display search query information -->
            <header class="page-header">
                <h1 class="page-title">
                    <?php printf(
                        esc_html__('Search Results for: %s', 'YOYO-Tube'),
                        '<span class="search-query">' . esc_html(get_search_query()) . '</span>'
                    ); ?>
                </h1>
                <p class="search-results-count">
                    <?php printf(
                        esc_html__('Found %d results.', 'YOYO-Tube'),
                        $wp_query->found_posts
                    ); ?>
                </p>
            </header>

            <!-- Loop through search results -->
             <?php if(have_posts()): ?>
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('search-result-card'); ?>>
                    <div class="card-content">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="card-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php $template_tags->get_the_post_custom_thumbnail(get_the_ID(), 'medium', ['class' => 'search-card-thumbnail']); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                            <h2 class="card-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <div class="card-excerpt">
                                <?php echo esc_html($template_tags->yoyo_the_excert()); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="read-more">
                                <?php esc_html_e('Read More', 'YOYO-Tube'); ?>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
            <?php endif; ?>

            <!-- Pagination -->
            <div class="pagination">
                <?= $template_tags->yoyo_pagination() ?>
            </div>
                            
        <?php else : ?>
            <!-- No results found -->
            <div class="no-results">
                <p><?php esc_html_e('No results found. Please try again with different keywords.', 'YOYO-Tube'); ?></p>
                <?php get_search_form(); // Display the search form ?>
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); // Reset the global $post object ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer(); // Include the footer template
?>

<?php
/**
 * The template for displaying search results
 *
 * @package YOYO-Tube
 */

get_header();

// Get search query
$search_query = get_search_query();
?>

<div class="container my-5">
    <div class="search-header mb-4">
        <h1 class="search-title">
            <?php 
            printf(
                esc_html__('Search Results for: %s', 'yoyo-tube'),
                '<span class="search-term">' . esc_html($search_query) . '</span>'
            ); 
            ?>
        </h1>
        
        <div class="search-meta">
            <?php 
            global $wp_query;
            $total_results = $wp_query->found_posts;
            
            printf(
                esc_html(_n(
                    'Found %s result',
                    'Found %s results',
                    $total_results,
                    'yoyo-tube'
                )),
                number_format_i18n($total_results)
            );
            ?>
        </div>
    </div>
    
    <?php if (have_posts()) : ?>
        <div class="video-grid">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/content', 'search'); ?>
            <?php endwhile; ?>
        </div>
        
        <div class="pagination-container mt-5">
            <?php
            echo paginate_links(array(
                'prev_text' => '<i class="fas fa-chevron-left"></i> Previous',
                'next_text' => 'Next <i class="fas fa-chevron-right"></i>',
            ));
            ?>
        </div>
        
    <?php else : ?>
        <div class="no-results-container text-center py-5">
            <i class="fas fa-search fa-4x mb-4 text-muted"></i>
            <h2 class="mb-3">No videos found</h2>
            <p class="mb-4">Sorry, but nothing matched your search terms. Please try again with different keywords.</p>
            
            <form role="search" method="get" class="search-form-large" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="input-group">
                    <input type="search" class="form-control" placeholder="Try another search..." name="s" value="<?php echo esc_attr($search_query); ?>">
                    <input type="hidden" name="post_type" value="yoyo_videos">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>


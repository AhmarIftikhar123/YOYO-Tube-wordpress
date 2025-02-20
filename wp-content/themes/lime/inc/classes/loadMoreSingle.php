<?php

namespace Inc\classes;

use Inc\Traits\Singleton;
use WP_Query;

/**
 * Load more script with AJAX
 */
class LoadMoreSingle {
    use Singleton;

    public function __construct() {
        $this->setup_hooks();
    }

    public function setup_hooks() {
        add_action('wp_ajax_nopriv_load_more', [$this, 'ajax_script_post_load_more']);
        add_action('wp_ajax_load_more', [$this, 'ajax_script_post_load_more']);

        add_shortcode('single_post_listings', [$this, 'single_post_load_more_container']);

        add_filter('posts_where', [$this, 'posts_where'], 10, 2);
    }

    public function single_post_load_more_container() {
        $single_post_id = get_the_ID();
        $load_more_query = $this->get_single_load_more_query(1, $single_post_id);
        $has_next_page = !empty($load_more_query->posts);
        $total_pages = $load_more_query->max_num_pages; // Use max_num_pages instead of max_num_comment_pages

        // If there are no more pages, don't render the load more button
        if (!$has_next_page) return null;

        ?>
<div class="single-post-loadmore-wrap h-100">
    <div id="load-more-content" class="single-post-loadmore">
        <?php // This is where more posts will be added ?>
    </div>
    <div class="text-center mb-5 mt-5">
        <button     
            id="single-load-more"
            data-page="1"
            data-single-post-id="<?php echo esc_attr($single_post_id); ?>"
            class="btn btn-primary"
            data-max-pages="<?php echo esc_attr($total_pages); ?>"
        >
            <span><?php esc_html_e('Load More Stories', 'aquila'); ?></span>
        </button>
        <span id="loading-text" class="mt-1 d-none">
            <?php esc_html_e('Loading...', 'aquila'); ?>
        </span>
    </div>
</div>
        <?php
    }

    public function get_single_load_more_query($page_no, $single_post_id) {
        $args = [
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'paged'          => $page_no,
            'starting_post_id'   => $single_post_id, // Exclude the current post
        ];
        return new WP_Query($args);
    }
    public function ajax_script_post_load_more(bool $initial_req = false) {
        if (!$initial_req && !check_ajax_referer('loadmore_post_nonce', 'ajax_nonce', false)) {
            wp_send_json_error(__('Invalid Security Token sent', 'text-domain'));
            wp_die();
        }

        $is_ajax_req = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

        if (!$initial_req && !$is_ajax_req) {
            wp_die();
        }

        $current_page = get_query_var('paged') ?: 1;
        $page_num = filter_var($_POST['page'] ?? null, FILTER_VALIDATE_INT);
        $page_num = $page_num ? $page_num + 1 : $current_page;

        $args = [
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 3,
            'paged'          => $page_num
        ];

        $query = new WP_Query($args);

        if ($query->have_posts()):
            while ($query->have_posts()):
                $query->the_post();
                get_template_part('template-parts/components/postCard');
            endwhile;
        else:
            wp_send_json_error(__('No more posts to load', 'YOYO-Tube'));
            wp_die();
        endif;

        wp_reset_postdata();

        if ($initial_req) {
            return;
        }

        wp_die();
    }
    /**
     * Modify the WHERE clause of the query to exclude a specific post by ID.
     *
     * @param string   $where The existing WHERE clause.
     * @param WP_Query $query The current WP_Query instance.
     * @return string Modified WHERE clause.
     */
    public function posts_where($where, $query) {
        global $wpdb;

        // Get the ID of the post to exclude
        $start = $query->get('starting_post_id');

        // If no starting post ID is provided, return the original WHERE clause
        if (empty($start)) {
            return $where;
        }

        // Exclude the specified post ID from the query results
        $where .= " AND $wpdb->posts.ID != $start";

        return $where;
    }
}
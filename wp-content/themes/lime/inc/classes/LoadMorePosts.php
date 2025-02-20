<?php

namespace Inc\classes;
use Inc\Traits\Singleton;
use WP_Query;

/**
 * Load more script with AJAX
 */
class LoadMorePosts {
    use Singleton;

    public function __construct() {
        $this->setup_hooks();
    }

    public function setup_hooks() {
        add_action('wp_ajax_nopriv_load_more', [$this, 'ajax_script_post_load_more']);
        add_action('wp_ajax_load_more', [$this, 'ajax_script_post_load_more']);
        add_shortcode('load_more', [$this, 'post_script_load_more']);
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

    public function post_script_load_more() {
        ?>
        <div class="load-more-content-wrap">
            <div id="load-more-content" class="row">
                <?php
                $this->ajax_script_post_load_more(true);
                ?>
            </div>
            <button id="load-more" data-page="1" class="btn btn-primary load-more-btn my-4 d-flex flex-row align-items-center gap-2 mx-auto px-4 py-2 border-0 ">
                <span><?php esc_html_e('Load More', 'text-domain'); ?></span>
                <?php get_template_part(slug: 'template-parts/svgs/loading'); ?>
            </button>
            <?php get_template_part(slug: 'template-parts/common/pagination.php'); ?>
        </div>
        <?php
    }
}
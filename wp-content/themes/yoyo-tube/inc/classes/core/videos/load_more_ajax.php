<?php
namespace Videos;
use Inc\traits\singleton;

class Load_more_ajax
{
          use Singleton;

          public function __construct()
          {
                    $this->setup_hooks();
          }

          public function setup_hooks()
          {
                    add_action('wp_ajax_load_more_videos', [$this, 'load_more_videos']);         // For logged in users
                    add_action('wp_ajax_nopriv_load_more_videos', [$this, 'load_more_videos']);  // For non-logged in users
          }
          // AJAX handler for loading more videos
          public function load_more_videos()
          {
                    // Check nonce for security
                    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'yoyo_load_more_nonce')) {
                              wp_send_json_error(array('message' => 'Security check failed'));
                    }

                    $page = isset($_POST['page']) ? intval($_POST['page']) : 2;

                    $args = array(
                              'post_type' => 'yoyo_videos',
                              'posts_per_page' => 5,
                              'orderby' => 'date',
                              'order' => 'DESC',
                              'paged' => $page,
                    );

                    $video_query = new \WP_Query($args);

                    ob_start();

                    if ($video_query->have_posts()) {
                              while ($video_query->have_posts()) {
                                        $video_query->the_post();
                                        get_template_part("template-parts/content");
                              }
                              wp_reset_postdata();

                              $html = ob_get_clean();
                              wp_send_json_success(array('html' => $html));
                    } else {
                              ob_get_clean();
                              wp_send_json_error(array('message' => 'No more videos to load'));
                    }
          }
}
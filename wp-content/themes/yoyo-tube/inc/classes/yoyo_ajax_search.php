<?php
/**
 * AJAX Search functionality for YOYO-Tube
 *
 * @package YOYO-Tube
 */

namespace Classes;
use Inc\Traits\Singleton;


if (!defined('ABSPATH')) {
          exit;
}

class YOYO_Ajax_Search
{
    use Singleton;


          public function __construct()
          {
                    $this->setup_hooks();
          }
          private function setup_hooks()
          {
                    add_action('init', [$this, 'register_ajax_search']);

          }
          public function register_ajax_search()
          {
                    add_action('wp_ajax_yoyo_ajax_search', [$this, 'ajax_search_callback']);
                    add_action('wp_ajax_nopriv_yoyo_ajax_search', [$this, 'ajax_search_callback']);
          }

          public function ajax_search_callback()
          {
                    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'yoyo_search_nonce')) {
                              wp_send_json_error(['message' => 'Security check failed']);
                    }

                    $search_term = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';

                    if (empty($search_term) || strlen($search_term) < 2) {
                              wp_send_json_error(['message' => 'Search term too short']);
                    }

                    $args = [
                              'post_type' => 'yoyo_videos',
                              'posts_per_page' => 5,
                              's' => $search_term,
                              'orderby' => 'relevance',
                              'tax_query' => [
                                        'relation' => 'OR',
                                        [
                                                  'taxonomy' => 'post_tag',
                                                  'field' => 'name',
                                                  'terms' => $search_term,
                                                  'operator' => 'LIKE',
                                        ],
                                        [
                                                  'taxonomy' => 'category',
                                                  'field' => 'name',
                                                  'terms' => $search_term,
                                                  'operator' => 'LIKE',
                                        ],
                              ],
                    ];

                    $search_query = new \WP_Query($args);
                    $total_count = (new \WP_Query(array_merge($args, ['posts_per_page' => -1, 'fields' => 'ids'])))->found_posts;

                    ob_start();
                    if ($search_query->have_posts()) {
                              while ($search_query->have_posts()) {
                                        $search_query->the_post();
                                        $this->render_search_result();
                              }
                              wp_reset_postdata();
                    } else {
                              $this->render_no_results();
                    }

                    wp_send_json_success([
                              'html' => ob_get_clean(),
                              'count' => $total_count,
                              'search_url' => home_url('/?s=' . urlencode($search_term) . '&post_type=yoyo_videos'),
                    ]);
          }

          private function render_search_result()
          {
                    $is_paid = get_post_meta(get_the_ID(), 'is_paid', true);
                    $video_price = get_post_meta(get_the_ID(), 'video_price', true);
                    $video_id = get_post_meta(get_the_ID(), 'video_id', true);
                    $categories = get_the_category();
                    $tags = get_the_tags();
                    $permalink = get_permalink();
                    if (!empty($video_id)) {
                              $permalink = add_query_arg('video_id', $video_id, $permalink);
                    }
                    ?>
                    <div class="search-result-item">
                              <div class="result-thumbnail">
                                        <a href="<?php echo esc_url($permalink); ?>">
                                                  <?php if (has_post_thumbnail()) {
                                                            the_post_thumbnail('thumbnail');
                                                  } else { ?>
                                                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder.jpg'); ?>"
                                                                      alt="<?php the_title_attribute(); ?>">
                                                  <?php } ?>
                                        </a>
                              </div>
                              <div class="result-content">
                                        <h4 class="result-title">
                                                  <a href="<?php echo esc_url($permalink); ?>"><?php the_title(); ?></a>
                                        </h4>
                                        <div class="result-meta">
                                                  <?php if (!empty($categories)) {
                                                            echo '<div class="result-category"><i class="fas fa-folder"></i>' . esc_html($categories[0]->name) . '</div>';
                                                  } ?>
                                                  <?php if (!empty($tags)) {
                                                            echo '<div class="result-tags"><i class="fas fa-tags"></i>' . esc_html($tags[0]->name) . (count($tags) > 1 ? ' <span>+' . (count($tags) - 1) . '</span>' : '') . '</div>';
                                                  } ?>
                                        </div>
                              </div>
                              <div class="result-price <?php echo $is_paid ? 'paid' : 'free'; ?>">
                                        <?php echo $is_paid ? '$' . esc_html($video_price) : 'Free'; ?>
                              </div>
                    </div>
                    <?php
          }

          private function render_no_results()
          {
                    ?>
                    <div class="no-results">
                              <i class="fas fa-search"></i>
                              <h4>No results found</h4>
                              <p>Try different keywords or check spelling</p>
                    </div>
                    <?php
          }
}


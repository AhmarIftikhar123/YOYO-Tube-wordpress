<?php
namespace core;

use Inc\traits\singleton;

class RegisterPostTypes
{
          use Singleton;

          public function __construct()
          {
                    $this->setup_hooks();
          }

          public function setup_hooks()
          {
                    // Register Custom Post Type Video
                    add_shortcode('video_upload_form', [$this, 'frontend_video_upload_form']);
                    // Display Videos on Homepage
                    add_shortcode('video_grid', [$this, 'display_video_grid']);
                    add_action('init', [$this, 'handle_video_upload']);
          }
          public function frontend_video_upload_form()
          {
                    if (!is_user_logged_in()) {
                              return '<p>You must be logged in to upload videos.</p>';
                    }

                    ob_start(); ?>
                    <form method="post" enctype="multipart/form-data">
                              <input type="text" name="video_title" placeholder="Video Title" required><br>
                              <textarea name="video_desc" placeholder="Video Description"></textarea><br>
                              <input type="file" name="video_file" accept="video/*" required><br>
                              <input type="submit" name="submit_video" value="Upload Video">
                    </form>
                    <?php
                    return ob_get_clean();
          }

          public function handle_video_upload()
          {
                    if (isset($_POST['submit_video']) && !empty($_FILES['video_file'])) {
                              $title = sanitize_text_field($_POST['video_title']);
                              $description = sanitize_textarea_field($_POST['video_desc']);
                              $file = $_FILES['video_file'];

                              // Upload to Media Library
                              $upload = wp_handle_upload($file, array('test_form' => false));

                              if ($upload && !isset($upload['error'])) {
                                        // Create a new post
                                        $post_id = wp_insert_post(array(
                                                  'post_title' => $title,
                                                  'post_content' => $description,
                                                  'post_status' => 'publish',
                                                  'post_type' => 'video',
                                                  'post_author' => get_current_user_id(),
                                        ));

                                        // Attach video to post
                                        update_post_meta($post_id, 'video_url', $upload['url']);

                                        echo '<p>Video uploaded successfully!</p>';
                              } else {
                                        echo '<p>Error uploading video.</p>';
                              }
                    }
          }
          public function display_video_grid()
          {
                    $videos = new \WP_Query(array(
                              'post_type' => 'video',
                              'posts_per_page' => 6,
                              'order' => 'DESC',
                    ));

                    ob_start(); ?>
                    <div class="video-grid">
                              <?php while ($videos->have_posts()):
                                        $videos->the_post();
                                        $video_url = get_post_meta(get_the_ID(), 'video_url', true);
                                        ?>
                                        <div class="video-item">
                                                  <video width="100%" controls>
                                                            <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                                                  </video>
                                                  <h3><?php the_title(); ?></h3>
                                        </div>
                              <?php endwhile;
                              wp_reset_postdata(); ?>
                    </div>
                    <style>
                              .video-grid {
                                        display: flex;
                                        flex-wrap: wrap;
                                        gap: 15px;
                              }

                              .video-item {
                                        width: 30%;
                                        background: #f4f4f4;
                                        padding: 10px;
                                        border-radius: 5px;
                              }
                    </style>
                    <?php return ob_get_clean();
          }
}
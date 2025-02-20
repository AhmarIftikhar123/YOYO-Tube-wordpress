<?php
namespace Inc\classes;

use Inc\Traits\Singleton;

class MetaBoxes
{
          use Singleton;

          public function __construct()
          {
                    $this->setup_hooks();
          }

          private function setup_hooks()
          {
                    add_action('add_meta_boxes', [$this, 'add_custom_meta_box']);
                    add_action('save_post', [$this, 'save_post_meta_box']);
          }
          public function add_custom_meta_box()
          {
                    $screens = ["post", "page"];
                    foreach ($screens as $screen) {
                              add_meta_box(
                                        'hide_page_title',
                                        'Hide Page Title',
                                        [$this, 'render_custom_meta_box'],
                                        $screen,
                                        'normal',
                                        'high'
                              );
                    }

          }
          public function render_custom_meta_box($post)
          {
                    wp_nonce_field('yoyo_tube_meta_box', 'yoyo_tube_meta_box_nonce');
                    $value = get_post_meta($post->ID, '_hide_page_title', true);
                    ?>
                    <label for="yoyo_tube_field">Hide the Page Title</label>
                    <select name="yoyo_tube_hide_title_field" id="yoyo_tube_field" class="postbox">
                              <option value="">Select</option>
                              <option value="yes" <?php selected($value, 'yes') ?>>Yes</option>
                              <option value="no" <?php selected($value, 'no') ?>>No</option>
                    </select>
                    <?php
          }
          public function save_post_meta_box($post_id)
          {
                    if (!current_user_can("edit_post", $post_id)) {
                              return;
                    }
                    if (!isset($_POST['yoyo_tube_hide_title_field']) || !wp_verify_nonce($_POST['yoyo_tube_meta_box_nonce'], 'yoyo_tube_meta_box')) {
                              return;
                    }
                    if (array_key_exists('yoyo_tube_hide_title_field', $_POST)) {
                              update_post_meta(
                                        $post_id,
                                        "_hide_page_title",
                                        $_POST['yoyo_tube_hide_title_field']
                              );
                    }
          }
}

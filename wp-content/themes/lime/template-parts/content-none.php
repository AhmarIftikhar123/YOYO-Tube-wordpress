<?php
/** 
 * Content-None Template
 * 
 * @package YOYO-Tube
 */
?>
<h1 class="site-title">No Post Found</h1>

<?php if (is_home() && current_user_can('publish_posts')) {
          echo wp_kses(
                    sprintf(
                              __("Ready to Publish new Post? <a href='%s'>Get started here</a>", "YOYO-Tube"),
                              esc_url(admin_url("post-new.php"))
                    ),
                    ["a" => ["href" => []]]

          );
} elseif (is_search()) {
          esc_html_e("Sorry, but nothing matched your search terms. Please try again with some different keywords.", "YOYO-Tube");
          get_search_form();
} else {
          esc_html_e("It seems we can't find what you'r looing for.Perhaps searching can help", "YOYO-Tube");
          get_search_form();
} ?>
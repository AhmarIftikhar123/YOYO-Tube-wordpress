<?php
/**
 * Archive-Settings
 * 
 * @package YOYO-Tube
 */

namespace Inc\classes;

use Inc\Traits\Singleton;

class ArchiveSettings
{
          use Singleton;

          protected function __construct()
          {
                    $this->setup_hooks();
          }

          private function setup_hooks()
          {
                    // Corrected the hook name by removing the extra space.
                    add_action('pre_get_posts', [$this, 'change_archive_post_per_page']);
          }



          public function change_archive_post_per_page($query)
          {
                    if ($query->is_archive() && !is_admin()  && $query->is_main_query()) {
                              $query->set('posts_per_page', strval(YOYO_ARCHIVE_POST_PER_PAGE));
                    }
                    elseif($query->query_var['s'] && ! is_admin()){
                              $query->set('posts_per_page', strval(YOYO_SEARCH_POST_PER_PAGE));
                    }
                    return $query;
          }
}
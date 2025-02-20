<?php
/**
 * blocks Catogery
 * 
 * @package YOYO-Tube
 */
namespace Inc\classes;

use Inc\Traits\Singleton;

class blocks
{
          use Singleton;

          public function __construct()
          {
                    $this->setup_hooks();
          }


          private function setup_hooks()
          {
                    add_action('block_categories', [$this, 'add_block_catogery']);
          }

          public function add_block_catogery(array $categories)
          {
                    $catogery_slug = wp_list_pluck($categories, 'slug');
                    if (!in_array('yoyo-tube', $catogery_slug, true)) {
                              $custom_bloc = [
                                        'slug' => 'YOYO-blocks',
                                        'title' => __('YOYO-Blocks', 'YOYO-Tube'),
                                        "icon" => "dashicons-editor-code"
                              ];
                              array_push($categories, $custom_bloc);
                    }
                    return $categories;
          }
}
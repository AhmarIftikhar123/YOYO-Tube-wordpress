<?php
namespace Inc\classes;

use Inc\Traits\Singleton;

class Manus
{
          use Singleton;

          public function __construct()
          {
                    add_action('init', [$this, 'register_menues']);
          }

          public function register_menues()
          {
                    register_nav_menu('yoyo-header-menu', esc_html(__('Header Menu', 'yoyo')));
                    register_nav_menu('yoyo-footer-menu', __('Footer Menu', 'yoyo'));
          }
          public function get_requested_id(string $location): int|string
          {
                    $locations = get_nav_menu_locations();
                    return $locations[$location] ?? "";
          }
          public function get_child_manu_items(array $manu_arr, int $parent_menu_id)
          {
                    $child_items = [];
                    if (!empty($manu_arr) && is_array($manu_arr)) {

                              foreach ($manu_arr as $item) {
                                        if ($item->menu_item_parent == $parent_menu_id) {
                                                  $child_items[] = $item;
                                        }
                              }
                    }
                    return $child_items;
          }
}
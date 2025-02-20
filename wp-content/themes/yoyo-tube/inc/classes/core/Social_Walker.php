<?php
namespace Core;
 class Social_Walker extends \Walker_Nav_Menu
{
          public function start_lvl(&$output, $depth = 0, $args = null)
          {
                    // Do nothing (we don't need a nested list)
          }

          public function end_lvl(&$output, $depth = 0, $args = null)
          {
                    // Do nothing (we don't need a nested list)
          }

          public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
          {
                    $classes = empty($item->classes) ? array() : (array) $item->classes;
                    $icon_class = '';

                    // Extract Font Awesome class if added in the menu item class
                    foreach ($classes as $class) {
                              if (strpos( $class, 'fa-') === 0) {
                                        $icon_class = esc_attr($class);
                                        break;
                              }
                    }

                    // Generate link with Font Awesome icon
                    $output .= '<a href="' . esc_url($item->url) . '" class="me-2 text-decoration-none" data-text="' . esc_attr($item->title) . '">
                        <i class="fa-brands ' . $icon_class . '"></i>
                    </a>';
          }

          public function end_el(&$output, $item, $depth = 0, $args = null)
          {
                    // Do nothing (no extra tags needed)
          }
}

<?php
namespace Inc\classes;

use Core\{assets, Menus, RegisterPostTypes};
use Inc\traits\singleton;
class yoyo_tube
{
          use singleton;
          public function __construct()
          {
                    Menus::getInstance();
                    assets::getInstance();
                    RegisterPostTypes::getInstance();
                    $this->setup_hooks();
          }

          public function setup_hooks()
          {
                    add_filter('body_class', [$this, 'Custom_body_classes']);
                    add_action('after_setup_theme', [$this, 'yoyo_tube_custom_theme_support']);
          }
          public function Custom_body_classes()
          {
                    $classes[] = 'container'; // Add your class here
                    return $classes;
          }
          public function yoyo_tube_custom_theme_support()
          {
                    add_theme_support('custom-logo', [
                              'height' => 100,  // Adjust as needed
                              'width' => 300,  // Adjust as needed
                              'flex-height' => true,
                              'flex-width' => true,
                              'header-text' => ['site-title', 'site-description'],
                    ]);
          }
}
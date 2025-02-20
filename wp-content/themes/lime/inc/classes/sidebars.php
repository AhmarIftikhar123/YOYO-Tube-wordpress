<?php
/**
 * Sidebars Class
 * 
 * @package YOYO-Tube
 */

namespace Inc\classes;

use Inc\Traits\Singleton;

class Sidebars
{
          use Singleton;

          public function __construct()
          {
                    $this->setup_hooks();
          }

          private function setup_hooks()
          {
                    add_action('widgets_init', [$this, 'register_sidebars']);
                    add_action('widgets_init', [$this, 'clockWidget']);
          }
          public function register_sidebars()
          {
                    register_sidebar([
                              'name' => __('Sidebar', 'YOYO-tube'),
                              'id' => 'sidebar',
                              "description" => __('Main-Sidebar', 'YOYO-tube'),
                              'before_widget' => '<div class="widget widget-sidebar">',
                              'after_widget' => '</div>',
                              'before_title' => '<h4 class="widget-title">',
                              'after_title' => '</h4>'
                    ]);

                    register_sidebar([
                              'name' => __('Footer', 'YOYO-tube'),
                              'id' => 'footer',
                              "description" => __('Main-Footer', 'YOYO-tube'),
                              'before_widget' => '<div class="widget footer-widget">',
                              'after_widget' => '</div>',
                              'before_title' => '<h4 class="widget-title">',
                              'after_title' => '</h4>'
                    ]);
          }
          public function clockWidget()
          {
                    register_widget('Inc\classes\clockWidget');
          }
}

<?php

namespace Inc\classes;

use Inc\Traits\Singleton;

class Lime
{
          use Singleton;

          public function __construct()
          {
                    $this->setup_hooks();
                    Assets::getInstance();
                    Manus::getInstance();
                    MetaBoxes::getInstance();
                    Sidebars::getInstance();
                    blocks::getInstance();
                    blockPattrens::getInstance();
                    LoadMorePosts::getInstance();
                    LoadMoreSingle::getInstance();
                    RegisterPostTypes::getInstance();
                    RegisterTaxonomies::getInstance();
                    ArchiveSettings::getInstance();
          }

          private function setup_hooks()
          {
                    // For Theme Functionalities
                    add_action('after_setup_theme', [$this, 'setup_theme']);
          }

          public function setup_theme()
          {
                    // Allow WP to manage website title
                    add_theme_support('title-tag');

                    // WP Custom Logo
                    add_theme_support('custom-logo', [
                              'header-text' => ['site-title', 'site-description'], // Disable site title and tagline
                              'height' => 50,
                              'width' => 50,
                              'flex-height' => true,
                              'flex-width' => true,
                    ]);

                    // WP Custom Backgroud-Color & img
                    add_theme_support('custom-background', array(
                              'default-color' => '0000ff',
                              'default-image' => 'https://unsplash.com/photos/woman-in-white-dress-covering-her-face-MA7Psk3lxlQ',
                              'default-position-x' => 'right',
                              'default-position-y' => 'top',
                              'default-repeat' => 'repeat',
                    ));
                    // WP Custom Thumbnail
                    add_theme_support('post-thumbnails');

                    // WP Custom Selective Refresh Widgets
                    add_theme_support('customize-selective-refresh-widgets');

                    // WP Automatic Custom Feed Links
                    add_theme_support('automatic-feed-links');
                    // WP html5 support
                    add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script']);

                    // WP add editor-style.css for Gutenburg Block editor Custom Styles
                    add_editor_style("asstes/dist/mini_css/editor.css");

                    // add DefaultWP Block Styles
                    // add_theme_support('wp-block-styles');

                    // Remove Core block Pattrens
                    remove_theme_support('core-block-patterns');

                    // WP Alignment of blocks
                    add_theme_support('align-wide');
                    add_theme_support('align-full');
                    // WP Custom Content Width
                    global $content_width;
                    if (!isset($content_width)) {
                              $content_width = 1240; // Set the content width to 800 pixels
                    }
                    add_image_size('featured-thumbnail', 500, 500, true);

                    // WP Post Formats
                    add_theme_support('post-formats', ['aside', 'gallery']);
          }
}

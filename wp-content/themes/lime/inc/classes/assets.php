<?php
namespace Inc\classes;

use Inc\Traits\Singleton;

class Assets
{
  use Singleton;

  public function __construct()
  {
    $this->setup_hooks();
  }

  private function setup_hooks()
  {
    add_action('wp_enqueue_scripts', [$this, 'register_styles']);
    add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
    add_action('enqueue_block_assets', [$this, 'enqueue_editor_assets']);
    add_action('wp_enqueue_scripts', [$this, 'remove_scripts']);
  }

  public function register_scripts()
  {
    // Enqueue jQuery
    wp_enqueue_script('jquery');

    // Register Bootstrap JS
    wp_register_script(
      'bootstrap_js',
      TEMPLATE_URI . "/assets/src/library/js/bootstrap.bundle.min.js",
      ['jquery'],
      filemtime(TEMPLATE_DIR . "/assets/src/library/js/bootstrap.bundle.min.js"),
      true
    );
    wp_enqueue_script('bootstrap_js');

    // Register Font Awesome
    wp_register_script(
      'font_awesome_js',
      'https://kit.fontawesome.com/6943d7505a.js',
      [],
      null,
      false
    );
    wp_enqueue_script('font_awesome_js');

    // Register Nav JS
    wp_register_script(
      'nav_js',
      TEMPLATE_URI . "/assets/src/js/nav/nav.js",
      [],
      filemtime(TEMPLATE_DIR . "/assets/src/js/nav/nav.js"),
      true
    );
    wp_enqueue_script('nav_js');

    // Register Main JS
    wp_register_script(
      'main_js',
      TEMPLATE_URI . "/dist/main.js",
      ['jquery', 'slick_js'],
      filemtime(TEMPLATE_DIR . "/dist/main.js"),
      true
    );
    wp_enqueue_script('main_js');

    // Register Slick.min.js
    wp_register_script(
      'slick_js',
      TEMPLATE_URI . "/dist/library/slick.min.js",
      ['jquery'],
      filemtime(TEMPLATE_DIR . "/dist/library/slick.min.js"),
      true
    );
    wp_enqueue_script('slick_js');

    // Register Slick.min.js
    wp_register_script(
      'single_js',
      TEMPLATE_URI . "/dist/single.js",
      ['jquery'],
      filemtime(TEMPLATE_DIR . "/dist/single.js"),
      true
    );
    // Conditionally enqueue single.js
    if (is_single() || is_front_page() || is_page() || is_archive()) {
      wp_enqueue_script('single_js');
    }

    wp_localize_script('main_js', 'siteConfig', [
      'ajaxURL' => admin_url('admin-ajax.php'),
      'ajax_nonce' => wp_create_nonce('loadmore_post_nonce')
    ]);

    // Register Author.js
    wp_register_script(
      'author_js',
      TEMPLATE_URI . "/dist/author.js",
      ['jquery'],
      filemtime(TEMPLATE_DIR . "/dist/author.js"),
      true
    );
    if (is_author()) {
      wp_enqueue_script('author_js');
    }

    // Register Search.js
    wp_register_script(
      'search_js',
      TEMPLATE_URI . "/dist/search.js",
      ['jquery', 'main_js'],
      filemtime(TEMPLATE_DIR . "/dist/search.js"),
      true
    );
    // Check if the current page is the search page
    if (is_page('search')) {
      // Get filters data
      // $filters_data = get_filters_data();

      // Enqueue the JavaScript file
      wp_enqueue_script('search_js');

      // Localize the script with data
      wp_localize_script('search_js', 'search_settings', [
        'rest_api_url' => home_url('/wp-json/af/v1/search'),
        'root_url' => home_url('search'),
        // 'filter_ids' => get_filter_ids($filters_data),
      ]);
    }

  }

  public function register_styles()
  {
    // Register Root Style
    wp_register_style(
      'root_style',
      TEMPLATE_URI . "/style.css",
      [],
      filemtime(TEMPLATE_DIR . "/style.css"),
      'all'
    );
    wp_enqueue_style('root_style');

    // Register Bootstrap CSS
    wp_register_style(
      'bootstrap_css',
      TEMPLATE_URI . "/assets/src/library/css/bootstrap.min.css",
      [],
      filemtime(TEMPLATE_DIR . "/assets/src/library/css/bootstrap.min.css"),
      'all'
    );
    wp_enqueue_style('bootstrap_css');

    // Register Navbar Style
    wp_register_style(
      'navbar_css',
      TEMPLATE_URI . "/assets/src/css/Navbar.min.css",
      [],
      filemtime(TEMPLATE_DIR . "/assets/src/css/Navbar.min.css"),
      'all'
    );
    wp_enqueue_style('navbar_css');

    // Register Main CSS
    wp_register_style(
      'main_css',
      TEMPLATE_URI . "/dist/mini_css/main.css",
      [],
      filemtime(TEMPLATE_DIR . "/dist/mini_css/main.css"),
      'all'
    );
    wp_enqueue_style('main_css');
    // Register slick slider.css
    wp_register_style(
      'slick_css',
      TEMPLATE_URI . "/dist/library/slick.css",
      [],
      filemtime(TEMPLATE_DIR . "/dist/library/slick.css"),
      'all'
    );
    wp_enqueue_style('slick_css');
    // Register slick slider-theme.css
    wp_register_style(
      'slick_theme_css',
      TEMPLATE_URI . "/dist/library/slick-theme.css",
      ['slick_css'],
      filemtime(TEMPLATE_DIR . "/dist/library/slick-theme.css"),
      'all'
    );
    wp_enqueue_style('slick_theme_css');

        // Register search.css
        wp_register_style(
          'search_css',
          TEMPLATE_URI . "/dist/mini_css/search.css",
          [],
          filemtime(TEMPLATE_DIR . "/dist/mini_css/search.css"),
          'all'
        );
        if(is_page('search')){
          wp_enqueue_style('search_css');
        }
  }

  public function remove_scripts()
  {
    // Remove unnecessary scripts
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wp-block-style'); // Remove WooCommerce block styles
  }

  public function enqueue_editor_assets()
  {
    // Path to the assets configuration file
    $assets_config_file = TEMPLATE_DIR . '/dist/assets.php';

    // Check if the configuration file exists; if not, stop execution
    if (!file_exists($assets_config_file)) {
      return;
    }

    // Include the assets configuration file
    $assets_config = require $assets_config_file;

    // Check if 'editor.js' is defined in the assets configuration; if not, stop execution
    if (empty($assets_config['editor.js'])) {
      return;
    }

    // Retrieve editor.js information from the assets configuration
    $editor_assets = $assets_config['editor.js'];

    // Extract dependencies and version for the script
    $js_dependencies = $editor_assets['dependencies'] ?? []; // Default to an empty array if not set
    $version = $editor_assets['version'] ?? filemtime($assets_config_file); // Use file modification time if version is not set

    // Register the editor JavaScript file for Gutenberg blocks
    wp_register_script(
      'yoyo_block_js', // Handle for the script
      TEMPLATE_URI . "/dist/block.js", // URL to the JavaScript file
      $js_dependencies, // Dependencies required by the script
      $version, // Version number for the script
      true // Load the script in the footer
    );

    // Enqueue the script only if in the WordPress admin dashboard
    if (is_admin()) {
      wp_enqueue_script('yoyo_block_js');
    }

    // Path to the CSS file for Gutenberg blocks
    $css_file = TEMPLATE_DIR . "/dist/mini_css/block.css";

    // Check if the CSS file exists
    if (file_exists($css_file)) {
      // Enqueue the Gutenberg blocks CSS
      wp_enqueue_style(
        'yoyo_blocks_css', // Handle for the stylesheet
        TEMPLATE_URI . "/dist/mini_css/block.css", // URL to the CSS file
        ['wp-block-library', 'wp-block-library-theme'], // Dependencies for the stylesheet
        filemtime($css_file), // Version number based on file modification time
        'all' // Media for which the stylesheet has been defined (e.g., all devices)
      );
    }
  }
}

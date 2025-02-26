<?php
/**
 * Class assets
 *
 * @package Inc\Classes
 * @author Ahmar Iftikhar
 *
 * This class is responsible for enqueuing all the styles and scripts for the theme.
 */
namespace Core;
use Inc\Traits\Singleton;

class assets
{
    use Singleton;

    public function __construct()
    {
        $this->setup_hooks();
    }

    private function setup_hooks()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        // add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
    }

    public function enqueue_styles()
    {
        // Enqueue Bootstrap CSS (Latest Version)
        wp_enqueue_style(
            'bootstrap-css',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
            [],
            '5.3.3'
        );

        // Enqueue Font Awesome (Latest Version)
        wp_enqueue_style(
            'font-awesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
            [],
            '6.5.1'
        );

        // Register Main CSS
        $main_css_path = TEMPLATE_DIR . "/dist/mini_css/main.css";
        if (file_exists($main_css_path)) {
            wp_register_style(
                'main-css',
                TEMPLATE_URI . "/dist/mini_css/main.css",
                ['bootstrap-css'],
                filemtime($main_css_path) // Cache busting
            );
            wp_enqueue_style('main-css');
        }
    }

    public function enqueue_scripts()
    {
        // Ensure jQuery is included
        wp_enqueue_script('jquery');

        // Enqueue Bootstrap JS (Latest Version)
        wp_enqueue_script(
            'bootstrap-js',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
            ['jquery'],
            '5.3.3',
            true
        );

        // Define main.js path and URL
        $upload_video_js_path = TEMPLATE_DIR . "/dist/upload_video.js";
        $upload_video_js_url = TEMPLATE_URI . "/dist/upload_video.js";

        // Register and enqueue upload_video.js
        wp_register_script(
            'upload_video-js',
            $upload_video_js_url,
            ['jquery'], // Ensure jQuery is a dependency
            filemtime($upload_video_js_path), // Cache busting
            true // Load in footer
        );

        wp_enqueue_script('upload_video-js');

        // Pass PHP data to JavaScript
        wp_localize_script('upload_video-js', 'yoyo_ajax', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('upload_video_action')
        ]);
    }

    public function enqueue_admin_scripts()
    {
        // Check if we are on the correct page
    }

}

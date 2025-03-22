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
        add_action('wp_enqueue_scripts', [$this, 'enqueue_localize']);
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
        // Enqueue Main JS File (Latest Version)
        wp_register_script(
            'main',
            BUILD_PATH . "/main.js",
            ['jquery'], // Ensure jQuery is a dependency
            filemtime(TEMPLATE_DIR . "build/main.js"), // Cache busting
            true // Load in footer
        );

        wp_enqueue_script('main');

        // Define upload_video.js path and URL
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



        // enqueue Authentication JS file for Video Player
        wp_register_script('authentication', BUILD_PATH . '/authentication.js', array('jquery'), filemtime(TEMPLATE_DIR . "/dist/authentication.js"), true);

        if (is_page('authentication')) {
            wp_enqueue_script('authentication');
        }


        wp_enqueue_script('stripe-js', 'https://js.stripe.com/v3/');

        if (is_page('video-player')) {
            wp_enqueue_script('stripe-payment-handler', BUILD_PATH . '/stripe.js', ['stripe-js'], filemtime(TEMPLATE_DIR . "/dist/stripe.js"), true);
        }
        if (is_front_page()) {
            wp_enqueue_script('load-more', BUILD_PATH . '/load_more.js', array('jquery'), filemtime(TEMPLATE_DIR . "/dist/load-more.js"), true);
        }

        // Enqueue author profile styles
        if (is_author()) {
            wp_enqueue_script('author', BUILD_PATH . '/author.js', array('jquery'), filemtime(TEMPLATE_DIR . "/dist/author.js"), true);
        }
        if (is_page('Contact Us')) {
            wp_enqueue_script('contact-us', BUILD_PATH . '/contact_us.js', ['stripe-js'], filemtime(TEMPLATE_DIR . "/dist/contact_us.js"), true);
        }
    }

    public function enqueue_admin_scripts()
    {
        // Check if we are on the correct page
    }
    public function enqueue_localize()
    {
        // Pass PHP data to JavaScript upload_video-js
        wp_localize_script('upload_video-js', 'yoyo_ajax', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('upload_video_action'),
            'home_url' => home_url()

        ]);
        // Pass PHP data to JavaScript upload_video-js
        wp_localize_script('authentication', 'yoyo_auth_ajax', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'security' => wp_create_nonce('yoyo_auth_nonce'),
            'home_url' => home_url()
        ]);
        // Pass PHP data to JavaScript stripe-js
        wp_localize_script('stripe-payment-handler', 'yoyo_stripe_ajax', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'security' => wp_create_nonce('yoyo_auth_nonce'),
            'stripe_nonce' => wp_create_nonce('yoyo_stripe_nonce'),
            'home_url' => home_url(),
        ]);
        if (is_front_page()) {
            // Pass AJAX URL and nonce to load-more.js
            wp_localize_script('load-more', 'yoyo_ajax_params', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('yoyo_load_more_nonce')
            ));
        }
        // Pass AJAX URL and nonce to script
        wp_localize_script('main', 'yoyo_search_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('yoyo_search_nonce')
        ));
        // Pass AJAX URL and nonce to script
        wp_localize_script('contact-us', 'contact_us_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('yoyo_contact_form_nonce')
        ));
    }

}

<?php
/**
 * Class YOYO_Contact_Form
 *
 * @package Inc\Classes
 * @author Ahmar Iftikhar
 *
 * This class is responsible for handling the contact form submissions securely.
 */
namespace Core;
use Inc\Traits\Singleton;

class Yoyo_contact_form
{
    use Singleton;

    public function __construct()
    {
        $this->setup_hooks();
    }

    private function setup_hooks()
    {
        add_action('wp_ajax_yoyo_contact_form', [$this, 'handle_form_submission']);
        add_action('wp_ajax_nopriv_yoyo_contact_form', [$this, 'handle_form_submission']);
    }

    public function handle_form_submission()
    {
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'yoyo_contact_form_nonce')) {
            wp_send_json_error(['message' => 'Invalid nonce'], 400);
        }

        // Sanitize input data
        $name = sanitize_text_field($_POST['name'] ?? '');
        $email = sanitize_email($_POST['email'] ?? '');
        $message = sanitize_textarea_field($_POST['message'] ?? '');

        // Validate required fields
        if (empty($name) || empty($email) || empty($message)) {
            wp_send_json_error(['message' => 'All fields are required'], 400);
        }

        if (!is_email($email)) {
            wp_send_json_error(['message' => 'Invalid email format'], 400);
        }

        // Prepare email
        $to = get_option('admin_email');
        $subject = 'New Contact Form Submission';
        $headers = ["From: $name <$email>", 'Content-Type: text/plain; charset=UTF-8'];
        $body = "Name: $name\nEmail: $email\nMessage: $message";

        // Send email
        if (wp_mail($to, $subject, $body, $headers)) {
            wp_send_json_success(['message' => 'Message sent successfully']);
        } else {
            wp_send_json_error(['message' => 'Failed to send message'], 500);
        }
    }

    public function localize_script()
    {
        wp_localize_script('yoyo-contact-form', 'yoyo_contact_params', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('yoyo_contact_form_nonce')
        ]);
    }
}

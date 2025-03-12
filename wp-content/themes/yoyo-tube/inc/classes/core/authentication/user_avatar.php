<?php
/**
 * Class user_avatar
 *
 * @package Inc\Classes\core\authentication
 * @author Ahmar Iftikhar
 *
 * This class is responsible for User Avatar 
 */
namespace Authentication;
use Inc\Traits\Singleton;

class user_avatar
{
    use Singleton;

    public function __construct()
    {
        $this->setup_hooks();
    }

    private function setup_hooks()
    {
        add_shortcode('google_avatar', [$this, 'display_google_avatar']);
    }

    public function display_google_avatar()
    {
        $current_user = wp_get_current_user();
        // Define authentication page URL (modify as needed)
        $auth_page_url = esc_url(site_url('/authentication'));

        // Define a placeholder image
        $placeholder = TEMPLATE_URI . '/assets/src/images/profile_img.png'; 

        // If user is NOT logged in, return the placeholder inside an <a> tag
        if (!$current_user->ID) {
            
            return '<a href="' . $auth_page_url . '">
                        <img src="' . esc_url($placeholder) . '" alt="Default Avatar" width="35" height="35">
                    </a>';
        }

        // Get avatar only if the user is logged in
        $avatar_url = $this->get_custom_user_avatar($current_user->ID);

        // If user is logged in, return the avatar
        return '<img src="' . esc_url($avatar_url) . '" class="rounded-circle" alt="User Avatar" width="35" height="35">';
    }

    private function get_custom_user_avatar($user_id)
    {
        // Get Google avatar from user meta
        $google_avatar = get_user_meta($user_id, '_nextend_social_avatar_google', true);

        // Get WordPress uploaded profile picture
        $wp_avatar = get_avatar_url($user_id);

        // Define a placeholder image
        $placeholder = TEMPLATE_URI . '/assets/src/images/profile_img.png'; // Change this to your actual placeholder image URL

        // Return the appropriate image
        return match (true) {
            !empty($google_avatar) => esc_url($google_avatar),
            !empty($wp_avatar) => esc_url($wp_avatar),
            default => esc_url($placeholder),
        };
    }
}

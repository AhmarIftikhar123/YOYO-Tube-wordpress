<?php
namespace Inc\classes;

use Authentication\authentication;
use Authentication\user_avatar;
use Author\Custom_author_profile;
use Classes\YOYO_Ajax_Search;
use Core\{assets, Menus, RegisterPostTypes};
use Core\Comments_support;
use Core\Short_codes;
use Core\Yoyo_contact_form;
use Inc\traits\singleton;
use Stripe\stripe_ajax;
use Videos\Load_more_ajax;
use Videos\Videos;
class yoyo_tube
{
    use singleton;
    public function __construct()
    {
        Menus::getInstance();
        assets::getInstance();
        RegisterPostTypes::getInstance();
        Videos::getInstance();
        authentication::getInstance();
        user_avatar::getInstance();
        stripe_ajax::getInstance();
        Short_codes::getInstance();
        Comments_support::getInstance();
        Load_more_ajax::getInstance();
        Custom_author_profile::getInstance();
        YOYO_Ajax_Search::getInstance();
        Yoyo_contact_form::getInstance();
        $this->setup_hooks();
    }

    public function setup_hooks()
    {
        add_filter('body_class', [$this, 'Custom_body_classes']);
        add_action('after_setup_theme', [$this, 'yoyo_tube_custom_theme_support']);
    }
    public function Custom_body_classes()
    {
        $classes[] = ''; // Add your class here
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
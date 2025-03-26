<?php
/**
 * Class Authentication
 *
 * @package Inc\Classes\core\authentication
 * @author Ahmar Iftikhar
 *
 * This class is responsible for User Log-in & Sign-UP
 */
namespace Authentication;
use Inc\Traits\Singleton;

class authentication
{
          use Singleton;

          public function __construct()
          {
                    $this->setup_hooks();
          }

          private function setup_hooks()
          {
                    add_action('wp_ajax_nopriv_yoyo_login', [$this, 'yoyo_login']);
                    add_action('wp_ajax_nopriv_yoyo_signup', [$this, 'yoyo_signup']);
          }
          public function yoyo_login()
          {
                    check_ajax_referer('yoyo_auth_nonce', 'security');

                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $remember = $_POST['remember'] === 'true';

                    $user = wp_signon(array(
                              'user_login' => $username,
                              'user_password' => $password,
                              'remember' => $remember
                    ));

                    if (is_wp_error($user)) {
                              wp_send_json_error(array('message' => $user->get_error_message()));
                    } else {
                              wp_send_json_success();
                    }
          }
          public function yoyo_signup()
          {
                    check_ajax_referer('yoyo_auth_nonce', 'security');

                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $role = $_POST['role'];

                    $user_id = wp_create_user($username, $password, $email);

                    if (is_wp_error($user_id)) {
                              wp_send_json_error(array('message' => $user_id->get_error_message()));
                    } else {
                              $user = new \WP_User($user_id);
                              $user->set_role($role);
                              // Send success with role info
                              wp_send_json_success(['role' => $role]);
                    }
          }
}

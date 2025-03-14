<?php
/**
 * Class stripe_ajax
 *
 * @package Inc\Classes
 * @author Ahmar Iftikhar
 *
 * This class is responsible for Stripe Payment Processing.
 */
namespace Stripe;
use Inc\Traits\Singleton;

class stripe_ajax
{
          use Singleton;

          public function __construct()
          {
                    $this->setup_hooks();
          }

          private function setup_hooks()
          {
                    add_action('wp_ajax_nopriv_handle_stripe_payment', [$this, 'handle_stripe_payment']);
                    add_action('wp_ajax_handle_stripe_payment', [$this, 'handle_stripe_payment']);
          }
          public function handle_stripe_payment()
          {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['stripeToken'], $_POST['video_id'])) {
                              \Stripe\Stripe::setApiKey('sk_test_51Q5gn6EQVKGjbQGAV1dtVCs6AYu4SKQTM6ZrLJqx9nfeWY70uBXdNwJ8NNO5gdn6a8Aikkycx5OZU6g002YS8bch003qAiEez1'); // your Stripe secret key
                              
                              $token = sanitize_text_field($_POST['stripeToken']);
                              $video_id = intval($_POST['video_id']);
                              $user_id = get_current_user_id(); // Get logged-in user
                              $video_url = get_post_meta($user_id, "video_url");

                              // Fetch video price (replace with actual query)
                              $video_price = get_post_meta($video_id, 'video_price', true);

                              try {
                                        $charge = \Stripe\Charge::create([
                                                  'amount' => $video_price * 100, // Convert to cents
                                                  'currency' => 'usd',
                                                  'description' => 'Payment for Video ID ' . $video_id,
                                                  'source' => $token,
                                                  'metadata' => ['video_id' => $video_id, 'user_id' => $user_id],
                                        ]);

                                        if ($charge->status === 'succeeded') {
                                                  global $wpdb;
                                                  $table_name = $wpdb->prefix . 'video_payments';

                                                  $wpdb->insert($table_name, [
                                                            'user_id' => $user_id,
                                                            'video_id' => $video_id,
                                                            'amount' => $video_price,
                                                            'transaction_id' => $charge->id,
                                                            'payment_status' => 'succeeded',
                                                            'created_at' => current_time('mysql')
                                                  ]);

                                                  // Return JSON success response
                                                  wp_send_json_success(['message' => 'Payment succeeded']);
                                        }
                              } catch (\Exception $e) {
                                        error_log('Stripe Payment Failed: ' . $e->getMessage());
                                        // Return JSON error response
                                        wp_send_json_error(['message' => 'Payment failed', 'error' => $e->getMessage()]);
                              }
                    }
          }
}
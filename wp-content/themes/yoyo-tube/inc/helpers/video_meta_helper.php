<?php
/**
 * Class assets
 *
 * @package Inc\Classes
 * @author Ahmar Iftikhar
 *
 * This class is responsible for enqueuing all the styles and scripts for the theme.
 */
namespace Inc\Helpers;
use Inc\Traits\Singleton;

class Video_meta_helper
{
    private $has_purchased; 
    use Singleton;

    public function is_already_purchased($current_item, $is_paid)
    {
        global $wpdb;
        $this->has_purchased = false;
        $user_id = get_current_user_id();

        if ($user_id && $current_item && $is_paid) {
            // Check the payment table for successful payments for this video by this user
            $payment_table = $wpdb->prefix . 'video_payments';
            $payment_exists = $wpdb->get_var($wpdb->prepare(
                "SELECT * FROM $payment_table 
                WHERE user_id = %d 
                AND video_id = %d 
                AND payment_status = 'succeeded'",
                $user_id,
                $current_item
            ));
            $this->has_purchased = ($payment_exists > 0);
        }
        return $this->has_purchased;
    }
}
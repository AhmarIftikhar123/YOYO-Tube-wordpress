<?php
/**
 * Entry Meta Template 
 * 
 * @package YOYO-Tube
 */

use Inc\Helpers\Video_meta_helper;

$current_item = get_the_ID();
$video_id = get_post_meta($current_item, 'video_id', true);
$video_price = get_post_meta($current_item, 'video_price', true);
$is_paid = get_post_meta($current_item, 'is_paid', true);

// Check if the current user has already purchased this video
$has_purchased = false;
if (is_user_logged_in()) {
    $Video_meta_helper_instance = Video_meta_helper::getInstance();
    $has_purchased = $Video_meta_helper_instance->is_already_purchased($current_item, $is_paid);
}
?>
<div class="video-meta <?= $is_paid ? 'is-paid' : 'is-free'; ?>">
    <span class="video-date"><?php echo get_the_date(); ?></span>
    <?php if ($is_paid): ?>
        <?php if ($has_purchased): ?>
            <span class="video-price purchased">Purchased</span>
        <?php else: ?>
            <span class="video-price">$<?php echo number_format($video_price, 2); ?></span>
        <?php endif; ?>
    <?php else: ?>
        <span class="video-price">Free</span>
    <?php endif; ?>
</div>
<?php
/**
 * Entry Meta Template 
 * 
 * @package YOYO-Tube
 */
$video_price = get_post_meta(get_the_ID(), 'video_price', true);
$is_paid = get_post_meta(get_the_ID(), 'is_paid', true);
?>
<div class="video-meta <?= $is_paid ? 'is-paid' : 'is-free'; ?>">
          <span class="video-date"><?php echo get_the_date(); ?></span>
          <?php if ($is_paid): ?>
                    <span class="video-price">$<?php echo number_format($video_price, 2); ?></span>
          <?php else: ?>
                    <span class="video-price">Free</span>
          <?php endif; ?>
</div>
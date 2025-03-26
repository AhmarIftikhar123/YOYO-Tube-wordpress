<?php
use Inc\Helpers\template_tags;
use Inc\Helpers\Video_meta_helper;

/**
 * Template part for displaying posts in the content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package YOYO-Tube
 */
$template_tags_Instance = template_tags::getInstance();
$current_item = get_the_ID();
$is_paid = get_post_meta($current_item, 'is_paid', true);
$video_link = get_post_meta($current_item, 'video_link', true);

$has_purchased = Video_meta_helper::getInstance();
$has_purchased = $has_purchased->is_already_purchased($current_item, $is_paid);

?>
<div class="video-description"><?php $template_tags_Instance->yoyo_the_excert(35); ?></div>
<?php if ($is_paid): ?>
    <?php if ($has_purchased): ?>
        <a href="<?php echo esc_url($video_link); ?>" class="btn-primary video-link text-decoration-none">Play Now</a>
    <?php else: ?>
        <a href="<?php echo esc_url($video_link); ?>" class="btn-primary video-link text-decoration-none">Get Access</a>
    <?php endif; ?>
<?php else: ?>
    <a href="<?php echo esc_url($video_link); ?>"
        class="btn-primary video-link text-decoration-none">Play Now</a>
<?php endif; ?>
<?php
use Inc\Helpers\template_tags;
/**
 * Template part for displaying posts in the content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package YOYO-Tube
 */
$template_tags_Instance = template_tags::getInstance();
$is_paid = get_post_meta(get_the_ID(), 'is_paid', true);


$video_link = get_post_meta(get_the_ID(), 'video_link', true);
?>
<div class="video-description"><?php $template_tags_Instance->yoyo_the_excert(35); ?></div>
<?php if ($is_paid): ?>
    <a href="<?php echo esc_url($video_link); ?>" class="btn-primary video-link text-decoration-none">Get Access</a>
<?php else: ?>
    <a href="<?php echo esc_url(get_permalink(get_page_by_path('check-out')->ID)); ?>" class="btn-primary video-link text-decoration-none">Play Now</a>
<?php endif; ?>

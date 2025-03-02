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
?>
<div class="video-description"><?php $template_tags_Instance->yoyo_the_excert(35); ?></div>
<a href="<?php esc_url( the_permalink()) ?>" class="btn-primary video-link text-decoration-none">Watch Video</a>


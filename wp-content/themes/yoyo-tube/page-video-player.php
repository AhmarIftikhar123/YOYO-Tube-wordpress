<?php
/*
Template Name: Video Player
*/
get_header();

if (!isset($_GET['video_id'])) {
    echo '<p>No video ID provided.</p>';
    get_footer();
    exit;
}

$video_id = intval($_GET['video_id']);
$video_post = get_post($video_id);
// var_dump($video_post);
if (!$video_post || $video_post->post_type !== 'yoyo_videos') {
    echo '<p>Invalid video ID.</p>';
    get_footer();
    exit;
}

$video_url = get_post_meta($video_id, 'video_url', true);
$thumbnail_url = get_post_meta($video_id, 'thumbnail_url', true);
$is_paid = get_post_meta($video_id, 'is_paid', true);
$video_price = get_post_meta($video_id, 'video_price', true);

if (false) {
    // Show payment form
    $this->render_payment_form($video_id, $video_price);
} else {
    // Show video player
    render_video_player($video_url, $thumbnail_url);
}

get_footer();

function has_user_paid($video_id) {
    // Implement your logic to check if the user has paid for the video
    // This could involve checking a user meta field or a custom table
    return false; // Placeholder
}

function render_payment_form($video_id, $video_price) {
    // Render the Stripe payment form
    echo '<div id="payment-form">';
    echo '<p>This video is paid content. Please pay $' . esc_html($video_price) . ' to unlock it.</p>';
    echo '<form action="" method="POST" id="stripe-payment-form">';
    echo '<input type="hidden" name="video_id" value="' . esc_attr($video_id) . '">';
    echo '<div id="card-element"><!-- Stripe Card Element will be inserted here --></div>';
    echo '<button id="submit-payment">Pay Now</button>';
    echo '</form>';
    echo '</div>';

    // Enqueue Stripe.js and your custom script
    wp_enqueue_script('stripe-js', 'https://js.stripe.com/v3/');
    wp_enqueue_script('stripe-payment-handler', get_template_directory_uri() . '/js/stripe-payment-handler.js', ['stripe-js'], null, true);
}

function render_video_player($video_url, $thumbnail_url) {
    // Render the video player
    echo '<div id="video-player">';
    echo '<video controls poster="' . esc_url($thumbnail_url) . '">';
    echo '<source src="' . esc_url($video_url) . '" type="video/mp4">';
    echo 'Your browser does not support the video tag.';
    echo '</video>';
    echo '</div>';
}
?>
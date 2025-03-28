<?php
namespace Stripe;
class stripe_payment
{
    private $video_id;
    private $video_post;
    private $video_url;
    private $thumbnail_url;
    private $is_paid;
    private $video_price;

    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        if (!isset($_GET['video_id']) && !strpos($_SERVER["REQUEST_URL"], '/video-player/')) {
            $this->render_error('No video ID provided.');
            return;
        }

        $this->video_id = intval($_GET['video_id']);
        $this->video_post = get_post($this->video_id);

        if (!$this->video_post || $this->video_post->post_type !== 'yoyo_videos') {
            $this->render_error('Invalid video ID.');
            return;
        }

        $this->video_url = get_post_meta($this->video_id, 'video_url', true);
        $this->thumbnail_url = get_post_meta($this->video_id, 'thumbnail_url', true);
        $this->is_paid = get_post_meta($this->video_id, 'is_paid', true);
        $this->video_price = get_post_meta($this->video_id, 'video_price', true);

    }
    private function render_error($message)
    {
        get_header();
        echo '<p class="error-message">' . esc_html($message) . '</p>';
        get_footer();
        exit;
    }
    public function render_page()
    {
        get_header();
        echo '<div class="video-player-container">';

        if ($this->is_paid && !$this->has_user_paid()) {
            $this->render_payment_form();
        } else {
            $this->render_video_player();
            $this->render_video_details();
            $this->render_comments();
        }


        echo '</div>';
        get_footer();
    }

    // ... (keep other existing methods)
    private function render_comments()
    {
        ?>
        <div class="video-comments">
            <h2>Comments</h2>
            <?php comments_template('video_comments.php'); ?>
        </div>
        <?php
        // enqueue video_player JS file for Video Player
        wp_register_script('video-player-script', BUILD_PATH . '/video_player.js', array('jquery'), filemtime(TEMPLATE_DIR . "/dist/vidoe_player.js"), true);

        if (is_page('video-player')) {
            wp_enqueue_script('video-player-script');
        }
    }

    private function render_video_details()
    {
        ?>
        <div class="video-details">
            <h1 class="video-title"><?php echo esc_html($this->video_post->post_title); ?></h1>
            <div class="video-meta">
                <span class="video-date"><?php echo esc_html(get_the_date('', $this->video_post)); ?></span>
                <?php if ($this->is_paid): ?>
                    <span class="video-price">$<?php echo number_format($this->video_price, 2); ?></span>
                <?php else: ?>
                    <span class="video-price">Free</span>
                <?php endif; ?>
            </div>
            <div class="video-description"><?php echo wpautop($this->video_post->post_content); ?></div>
        </div>
        <?php
    }
    private function render_payment_form()
    {
        ?>
        <div id="payment-form" class="payment-form">
            <p>This video is paid content. Please pay $<?php echo esc_html($this->video_price); ?> to unlock it.</p>
            <form id="stripe-payment-form">
                <input type="hidden" id="video_id" name="video_id" value="<?php echo esc_attr($this->video_id); ?>">
                <div id="card-element"><!-- Stripe Card Element will be inserted here --></div>
                <button id="submit-payment" class="btn-primary">Pay Now</button>
            </form>
        </div>
        <?= do_shortcode('[yoyo_toast]'); ?>
    <?php
    }

    private function has_user_paid()
    {
        global $wpdb;
        $user_id = get_current_user_id(); // Get the logged-in user ID
        $video_id = $this->video_id; // The video ID you want to check

        $payment = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM wp_video_payments WHERE user_id = %d AND video_id = %d AND payment_status = 'succeeded'",
                $user_id,
                $video_id
            )
        );
        return $payment ? true : false;
    }
    private function render_video_player()
    {
        ?>
        <div id="custom-video-player" class="custom-video-player">
            <video id="video" poster="<?php echo esc_url($this->thumbnail_url); ?>">
                <source src="<?php echo esc_url($this->video_url); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="video-controls">
                <button class="play-pause-btn" title="Play/Pause">
                    <i class="fas fa-play"></i>
                </button>
                <div class="seekbar-wrapper w-100 position-relative">
                    <input type="range" class="seek-bar" value="0">
                </div>
                <div class="time d-flex gap-2">
                    <span class="current-time">0:00</span>
                    /
                    <span class="duration">0:00</span>
                </div>
                <div class="volume-container">
                    <button class="mute-btn" title="Mute/Unmute">
                        <i class="fas fa-volume-up"></i>
                    </button>
                    <div class="volume-bar-wrapper w-100 position-relative">
                        <input type="range" class="volume-bar" min="0" max="1" step="0.1" value="1">
                    </div>
                </div>
                <button class="fullscreen-btn" title="Fullscreen">
                    <i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        <?php
    }

}

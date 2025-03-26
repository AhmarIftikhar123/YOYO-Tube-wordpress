<?php
/**
 * Class assets
 *
 * @package Inc\Classes
 * @author Ahmar Iftikhar
 *
 * This class is responsible for Short Codes
 */
namespace Core;
use Inc\Traits\Singleton;

class Short_codes
{
  use Singleton;

  public function __construct()
  {
    $this->setup_hooks();
  }

  private function setup_hooks()
  {
    add_shortcode('yoyo_toast', [$this, 'yoyo_toast']);
    // Add the toast to the footer
    add_action('wp_footer', [$this, 'add_toast_to_video_pages']);
    add_shortcode('yoyo_restricted_content', [$this, 'yoyo_restricted_content_shortcode']);
  }

  public function yoyo_toast()
  {
    ob_start(); ?>

    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
      <div id="yoyo-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
          <div class="toast-icon me-2">
            <i class="fas fa-info-circle"></i>
          </div>
          <strong class="me-auto toast-title">Notification</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          Message goes here
        </div>
      </div>
    </div>

    <?php
    return ob_get_clean();
  }
  public function add_toast_to_video_pages()
  {
    if (is_front_page() || is_page("authentication")) {
      echo do_shortcode('[yoyo_toast]');
    }
  }
  public function yoyo_restricted_content_shortcode($atts, $content = null)
  {
    // Parse attributes
    $atts = shortcode_atts(
      array(
        'redirect' => wp_login_url(get_permalink()),
        'message' => 'This content is only available to logged-in users.',
        'button_text' => 'Log In Now',
      ),
      $atts,
      'yoyo_restricted_content'
    );

    ob_start();
    ?>
    <div class="restricted-content-message" data-redirect="<?php echo esc_url($atts['redirect']); ?>">
      <i class="fas fa-lock lock-icon"></i>
      <h3>Restricted Content</h3>
      <p><?php echo esc_html($atts['message']); ?></p>

      <div class="countdown-container">
        <span class="countdown">5</span>
        <span class="countdown-text">seconds until redirect</span>
      </div>

      <a href="<?php echo esc_url($atts['redirect']); ?>" class="auth-button">
        <i class="fas fa-sign-in-alt"></i> <?php echo esc_html($atts['button_text']); ?>
      </a>

      <div class="redirect-progress">
        <div class="progress-bar"></div>
      </div>
    </div>
    <?php
    return ob_get_clean();
  }
}

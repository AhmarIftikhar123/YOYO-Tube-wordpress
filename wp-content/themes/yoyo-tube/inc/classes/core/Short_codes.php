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
    add_action('wp_footer', [$this, 'add_toast_to_video_pages']);
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
    if (is_front_page()) {
      echo do_shortcode('[yoyo_toast]');
    }
  }
}

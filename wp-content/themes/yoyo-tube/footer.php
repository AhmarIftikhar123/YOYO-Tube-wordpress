<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package YOYO-Tube
 */

use Core\Menus;
use Core\Social_Walker;

// Instantiate the menu class
$menu_instances = Menus::getInstance();

$footer_menu_id = $menu_instances->get_nav_menu_id('yoyo-tube-footer-menu');
$footer_menu_items = wp_get_nav_menu_items($footer_menu_id);
$get_current_user_id = get_current_user_id(); // Get the current user ID

?>

<footer id="colophon" class="site-footer footer text-center clr_light_gray bg_darkest_black">
	<div class="container fs_90">
		<div class="row py-4">
			<!-- Site Info Section -->
			<div class="col-md-4 mx-auto">
				<h5 class="mb-1 fw-semibold">YoYo Tube</h5>
				<p class="mb-1">Share and enjoy amazing Vid!</p>
			</div>

			<!-- Dynamic Footer Menu -->
			<div class="col-md-4">
				<h5 class="mb-1 fw-semibold">Quick Links</h5>
				<?php if (!empty($footer_menu_items)): ?>
					<?php $menu_instances->render_nav_menu($footer_menu_items, $get_current_user_id, false);
					?>
				<?php else: ?>
					<p>No menu assigned. Please set up a Footer Menu.</p>
				<?php endif; ?>
			</div>

			<!-- Social Media Links -->
			<div class="col-md-4">
				<h5 class="mb-1 fw-semibold">Follow Us</h5>
				<?php if (has_nav_menu('yoyo-tube-social-menu')): ?>
					<div
						class="social_media_icons d-flex align-items-center justify-content-center gap-2 my-2">
						<?php
						wp_nav_menu(array(
							'theme_location' => 'yoyo-tube-social-menu',
							'container' => false,
							'items_wrap' => '%3$s', // Removes default <ul> wrapper
							'walker' => new Social_Walker(),
						));
						?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>

</html>
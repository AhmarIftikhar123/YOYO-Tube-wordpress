<?php
/**
 * YOYO-Tube functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package YOYO-Tube
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function yoyo_tube_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on YOYO-Tube, use a find and replace
	 * to change 'yoyo-tube' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('yoyo-tube', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// // This theme uses wp_nav_menu() in one location.
	// register_nav_menus(
	// 	array(
	// 		'menu-1' => esc_html__( 'Primary', 'yoyo-tube' ),
	// 	)
	// );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'yoyo_tube_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'yoyo_tube_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function yoyo_tube_content_width()
{
	$GLOBALS['content_width'] = apply_filters('yoyo_tube_content_width', 640);
}
add_action('after_setup_theme', 'yoyo_tube_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function yoyo_tube_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'yoyo-tube'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'yoyo-tube'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'yoyo_tube_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function yoyo_tube_scripts()
{
	wp_enqueue_style('yoyo-tube-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('yoyo-tube-style', 'rtl', 'replace');

	wp_enqueue_script('yoyo-tube-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'yoyo_tube_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

function yoyo_custom_comment($comment, $args, $depth) {
	?>
	<div id="comment-<?php comment_ID(); ?>" <?php comment_class('comment-item'); ?>>
	    <div class="comment-body">
	        <div class="comment-meta">
		  <div class="comment-author">
		      <?php echo get_avatar($comment, 50, '', '', array('class' => 'comment-avatar')); ?>
		      <div class="author-info">
			<?php printf('<cite class="fn">%s</cite>', get_comment_author_link()); ?>
			<div class="comment-metadata">
			    <time datetime="<?php comment_time('c'); ?>">
			        <?php
			        printf(
				  _x('%1$s at %2$s', '1: date, 2: time'),
				  get_comment_date(),
				  get_comment_time()
			        );
			        ?>
			    </time>
			    <?php edit_comment_link(__('Edit'), ' <span class="edit-link">', '</span>'); ?>
			</div>
		      </div>
		  </div>
	        </div>
      
	        <div class="comment-content">
		  <?php comment_text(); ?>
	        </div>
      
	        <?php if ('0' == $comment->comment_approved) : ?>
		  <p class="comment-awaiting-moderation">
		      <?php _e('Your comment is awaiting moderation.'); ?>
		  </p>
	        <?php endif; ?>
      
	        <div class="reply">
		  <?php
		  comment_reply_link(array_merge($args, array(
		      'reply_text' => __('Reply'),
		      'depth' => $depth,
		      'max_depth' => $args['max_depth']
		  )));
		  ?>
	        </div>
	    </div>
	<?php
      }
      function custom_comment_redirect($location, $comment) {
	      if (isset($_POST['video_id'])) {
	//     wp_die('custom_comment_redirect is called');
        $video_id = intval($_POST['video_id']);
        $location = site_url('/video-player/?video_id=' . $video_id . '#comment-' . $comment->comment_ID);
    }
    return $location;
}
add_filter('comment_post_redirect', 'custom_comment_redirect', 10, 2);
function add_video_id_to_comment_pagination($link) {
	if (isset($_GET['video_id'])) {
		// wp_die('add_video_id_to_comment_pagination is called');
	    $video_id = intval($_GET['video_id']);
	    $link = add_query_arg('video_id', $video_id, $link);
	}
	return $link;
      }
      add_filter('paginate_comments_links', 'add_video_id_to_comment_pagination');
      add_filter('get_comment_link', 'add_video_id_to_comment_pagination');
      

use Inc\classes\yoyo_tube;

// /var/www/html/wp-content/themes/yoyo-tube
define('TEMPLATE_DIR', untrailingslashit(get_template_directory()));

// http://localhost:8001/wp-content/themes/yoyo-tube
define('TEMPLATE_URI', untrailingslashit(get_template_directory_uri()));
// http://localhost:8001/wp-content/themes/yoyo-tube/dist
define('BUILD_PATH', TEMPLATE_URI . "/dist");

define('YOYO_ARCHIVE_POST_PER_PAGE', 9);

define('YOYO_SEARCH_POST_PER_PAGE', 9);

require_once TEMPLATE_DIR . "/vendor/autoload.php";

$yoyo_tube = yoyo_tube::getInstance();
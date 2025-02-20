<?php

use Inc\classes\Lime;
use Inc\classes\Assets;

/**
 * The Functions
 * 
 * @package YoYo-Tube
 */
?>
<?php
// /var/www/html/wp-content/themes/lime
define('TEMPLATE_DIR', untrailingslashit(get_template_directory()));

// http://localhost:8001/wp-content/themes/lime
define('TEMPLATE_URI', untrailingslashit(get_template_directory_uri()));
// http://localhost:8001/wp-content/themes/lime/dist
define('BUILD_PATH', TEMPLATE_DIR . "/dist");

define('YOYO_ARCHIVE_POST_PER_PAGE', 9);

define('YOYO_SEARCH_POST_PER_PAGE', 9);
require_once TEMPLATE_DIR . "/vendor/autoload.php";

/**
 * get_stylesheet_uri() = http://localhost:8001/wp-content/themes/lime/style.css
 */
// function force_single_template($template) {
//           if (is_singular()) {
//               $template = locate_template('single.php');
//           }
//           return $template;
//       }
//       add_filter('template_include', 'force_single_template');
$Aquila_Instance = Lime::getInstance();

// ?>
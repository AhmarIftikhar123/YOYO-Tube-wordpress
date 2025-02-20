<?php

use Core\Menus;

$Menu_Instance = Menus::getInstance();
$required_menu_item_id = $Menu_Instance->get_nav_menu_id('yoyo-tube-header-menu');

$header_menu_items = (!empty($required_menu_item_id)) ? wp_get_nav_menu_items($required_menu_item_id) : [];
$current_user_id = get_current_user_id(); // Get the current user ID
?>

<header id="masthead" class="site-header">
    <nav class="navbar navbar-expand-lg bg_darkest_black fs_1_5 clr_aqua">
        <div class="container">
            <a class="navbar-brand clr_teal" href="<?= esc_url(home_url('/')); ?>">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <span><?= esc_html(get_bloginfo('name', 'display')); ?></span>
                <?php endif; ?>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <?php  $Menu_Instance->render_nav_menu($header_menu_items, $current_user_id); ?>
            </div>
        </div>
    </nav>
</header>


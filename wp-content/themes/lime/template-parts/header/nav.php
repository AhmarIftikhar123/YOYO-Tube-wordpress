<!-- Logout Logic -->
<?php
use Inc\classes\Manus;

$Menus_Instance = new Manus();

// Get the requested menu ID for the "yoyo-header-menu" location
$Menu_id = $Menus_Instance->get_requested_id('yoyo-header-menu');

// Get all items using Menu_ID
$Menu_items = wp_get_nav_menu_items($Menu_id);
?>

<nav class="navbar navbar-expand-lg bg_darkest_black fs_1_5 clr_aqua">
    <div class="container">
        <a class="navbar-brand clr_teal" href="/home">
            <?php
            if (function_exists('the_custom_logo') && has_custom_logo()) {
                // Display the custom logo
                the_custom_logo();
            } else {
                // Fallback to site title if no logo is set
                echo '<h1 class="site-title">' . esc_html(get_bloginfo('name')) . '</h1>';
            }
            ?>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav gap-4 ms-auto align-items-center">
                <?php
                // Loop through all menu items
                foreach ($Menu_items as $Menu_item) {
                    // Get child menu items for the current menu item
                    $get_parent_items = $Menus_Instance->get_child_manu_items($Menu_items, $Menu_item->ID);

                    // Render only top-level menu items (menu_item_parent == 0)
                    if ($Menu_item->menu_item_parent == 0) {
                        if (empty($get_parent_items)) {
                            // No child items, render as a regular menu link
                            echo '<li class="nav-item clr_light_gray text-center">
                                <a class="nav-link px-0" href="' . esc_url($Menu_item->url) . '" id="uploadVideo">' .
                                esc_html($Menu_item->title) .
                                '</a>
                            </li>';
                        } else {
                            // Has child items, render as a dropdown menu
                            echo '<li class="nav-item dropdown clr_light_gray text-center">
                                <a class="nav-link dropdown-toggle px-0" href="#" id="navbarDropdown" role="button" 
                                    data-bs-toggle="dropdown" aria-expanded="false">' .
                                esc_html($Menu_item->title) .
                                '</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                            foreach ($get_parent_items as $parent_item) {
                                echo '<li><a class="dropdown-item" href="' . esc_url($parent_item->url) . '">' .
                                    esc_html($parent_item->title) .
                                    '</a></li>';
                            }
                            echo '</ul>
                            </li>';
                        }
                    }
                }
                ?>
                <?php get_search_form(); ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Offcanvas for profile -->
<div class="offcanvas offcanvas-end bg_darkest_black clr_light_gray" tabindex="-1" id="profileOffcanvas"
     aria-labelledby="profileOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title navbar-brand" id="profileOffcanvasLabel">Profile Info</h5>
        <i class="fa-solid fa-xmark d-block ms-auto" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></i>
    </div>
    <div class="offcanvas-body fs_90">
        <div class="row profile_info">
            <div class="col-sm-2 col-12">
                <?php if (!empty($user['profile_image'])): ?>
                    <img src="data:image/jpeg;base64,<?= $user['profile_image'] ?>"
                         alt="Profile Image" class="profile_image rounded-circle">
                <?php else: ?>
                    <i class="fa-solid fa-user"></i>
                <?php endif; ?>
            </div>

            <div class="col">
                <h6 class="profile-username mb-1 fs_90"><?= $user['username']; ?></h6>
                <p class="profile-email mb-0 fs_90"><?= $user['email']; ?></p>
            </div>
        </div>

        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle d-block mx-auto my-2 fs_inherit" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                Account Settings
            </button>
            <ul class="dropdown-menu fs_inherit clr_light_gray bg_darkest_black p-0">
                <li><a class="dropdown-item clr_darkest_black bg_light_gray" href="/videos">Your Posts</a></li>
                <li><a class="dropdown-item clr_darkest_black bg_light_gray" href="/profile">Update Profile</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast-container position-fixed top-25 end-0 p-3">
    <div id="profileToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg_light_gray clr_darkest_black">
            <i class="fa-solid fa-exclamation me-2"></i>
            <strong class="me-auto navbar-brand">YOYO Tube</strong>
            <i class="fa-solid fa-xmark ms-1" type="button" data-bs-dismiss="toast" aria-label="Close"></i>
        </div>
        <div class="toast-body bg_darkest_black clr_light_gray">
            <p class="text-center">You are not logged in or registered, please 
                <a href="/authentication" class="nav-link d-inline">login</a> or 
                <a href="/authentication?register=true" class="nav-link d-inline">register</a> first.
            </p>
        </div>
    </div>
</div>

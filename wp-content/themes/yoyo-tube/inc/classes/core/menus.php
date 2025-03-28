<?php
/**
 * Class Menus
 *
 * @package Core
 * @author Ahmar Iftikhar
 *
 * This class is responsible for registering and rendering menus.
 */

namespace Core;

use Inc\Traits\Singleton;

class Menus
{
    use Singleton;

    public function __construct()
    {
        $this->setup_hooks();
    }

    private function setup_hooks()
    {
        add_action('init', [$this, 'register_menus']);
    }

    public function register_menus()
    {
        register_nav_menu('yoyo-tube-header-menu', esc_html__('Header Menus', 'YOYO-Tube'));
        register_nav_menu('yoyo-tube-footer-menu', esc_html__('Footer Menus', 'YOYO-Tube'));
        register_nav_menu('yoyo-tube-social-menu', esc_html__('Social Menu', 'YOYO-Tube'));
    }

    public function get_nav_menu_id($required_menu_item)
    {
        $locations = get_nav_menu_locations();
        return $locations[$required_menu_item] ?? wp_die("Requested Menu item not Found");
    }

    public function get_child_menu_items($all_menu_items_arr, $parent_Id)
    {
        $child_items_arr = [];

        if (!empty($all_menu_items_arr) && is_array($all_menu_items_arr)) {
            foreach ($all_menu_items_arr as $menu_item) {
                if ($menu_item->menu_item_parent == $parent_Id) {
                    $child_items_arr[] = $menu_item;
                }
            }
        }

        return $child_items_arr;
    }

    public function render_dropdown_menu($menu_item, $has_children, $is_header)
    {
        ?>
        <li class="nav-item dropdown m-0">
            <button class="btn btn-secondary dropdown-toggle mx-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?= esc_html($menu_item->title) ?>
            </button>
            <ul class="dropdown-menu">
                <?php foreach ($has_children as $child): ?>
                    <li>
                        <a class="dropdown-item" href="<?= esc_url($child->url) ?>">
                            <?= esc_html($child->title) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
        <?php
    }

    public function render_menu_item($menu_item)
    {
        ?>
        <li class="nav-item text-center">
            <a class="nav-link px-0" href="<?= esc_url($menu_item->url) ?>">
                <?= esc_html($menu_item->title) ?>
            </a>
        </li>
        <?php
    }

    public function render_theme_toggler()
    {
        ?>
        <li class="nav-item">
            <button id="themeToggler">
                <i class="fa-solid fa-sun"></i>
            </button>
        </li>
        <?php
    }

    /**
     * Render search form in the navigation
     */
    public function render_search_form()
    {
        ?>
        <li class="nav-item search-container">
            <button type="button" class="search-toggle">
                <i class="fas fa-search"></i>
            </button>
            
            <form class="search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="hidden" name="post_type" value="yoyo_videos">
                <button type="button" class="search-close">
                    <i class="fas fa-times"></i>
                </button>
                <input type="search" class="search-input" placeholder="Search videos..." name="s" autocomplete="off">
                <button type="submit" class="search-submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            
            <!-- Search Results Dropdown -->
            <div class="search-results-container">
                <div class="search-results-header">
                    <h3>Results <span class="results-count">0</span></h3>
                    <button type="button" class="close-results">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="search-loading">
                    <div class="spinner"></div>
                    <p>Searching...</p>
                </div>
                
                <div class="search-results-list">
                    <!-- Results will be loaded here via AJAX -->
                </div>
                
                <div class="search-results-footer">
                    <a href="#" class="view-all-results">
                        View all results <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </li>
        <?php
    }

    public function render_profile_image($current_user_id)
    {
        if (!is_author()) {
            $user_id = get_current_user_id();
            $profile_url = get_author_posts_url($user_id);
        }
        ?>
        <a href="<?= esc_url($profile_url ?? "") ?>" class="nav-item text-center profile_image_container">
            <?= do_shortcode('[google_avatar]') ?>
        </a>
        <?php ;
    }

    public function render_nav_menu($header_menu_items, $current_user_id, $is_header = true)
    {
        if (!empty($header_menu_items)): ?>
            <?php $gap = $is_header ? "gap-3" : ""; ?>
            <ul class="<?= 'navbar-nav ' . $gap . ' ms-auto align-items-center' ?>">
                <?php foreach ($header_menu_items as $menu_item): ?>
                    <?php $has_children = $this->get_child_menu_items($header_menu_items, $menu_item->ID); ?>
                    <?php
                    if (!empty($has_children)) {
                        $this->render_dropdown_menu($menu_item, $has_children, $is_header);
                    } elseif (empty($menu_item->menu_item_parent)) {
                        $this->render_menu_item($menu_item);
                    }
                    ?>
                <?php endforeach; ?>
                <?php if (!$is_header)
                    return; ?>
                <?php // $this->render_theme_toggler(); ?>
                <?php $this->render_search_form(); // Add search form before profile image ?>
                <?php $this->render_profile_image($current_user_id); ?>
            </ul>
        <?php endif;
    }
}


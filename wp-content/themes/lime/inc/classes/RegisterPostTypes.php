<?php
/**
 * Custom Post tyles
 * 
 * @package YOYO-Tube
 */
namespace Inc\classes;

use Inc\Traits\Singleton;

class RegisterPostTypes
{
          use Singleton;

          public function __construct()
          {
                    $this->setup_hooks();
          }


          private function setup_hooks()
          {
                    add_action('init', [$this, 'create_custompost_cpt']);
          }
          function create_custompost_cpt()
          {

                    $labels = array(
                              'name' => _x('Movies', 'Post Type General Name', 'YOYO-Tube'),
                              'singular_name' => _x('Movie', 'Post Type Singular Name', 'YOYO-Tube'),
                              'menu_name' => _x('Movies', 'Admin Menu text', 'YOYO-Tube'),
                              'name_admin_bar' => _x('Movie', 'Add New on Toolbar', 'YOYO-Tube'),
                              'archives' => __('Movie Archives', 'YOYO-Tube'),
                              'attributes' => __('Movie Attributes', 'YOYO-Tube'),
                              'parent_item_colon' => __('Parent Movie:', 'YOYO-Tube'),
                              'all_items' => __('All Movies', 'YOYO-Tube'),
                              'add_new_item' => __('Add New Movie', 'YOYO-Tube'),
                              'add_new' => __('Add New', 'YOYO-Tube'),
                              'new_item' => __('New Movie', 'YOYO-Tube'),
                              'edit_item' => __('Edit Movie', 'YOYO-Tube'),
                              'update_item' => __('Update Movie', 'YOYO-Tube'),
                              'view_item' => __('View Movie', 'YOYO-Tube'),
                              'view_items' => __('View Movies', 'YOYO-Tube'),
                              'search_items' => __('Search Movie', 'YOYO-Tube'),
                              'not_found' => __('Not found', 'YOYO-Tube'),
                              'not_found_in_trash' => __('Not found in Trash', 'YOYO-Tube'),
                              'featured_image' => __('Movie Poster', 'YOYO-Tube'),
                              'set_featured_image' => __('Set movie poster', 'YOYO-Tube'),
                              'remove_featured_image' => __('Remove movie poster', 'YOYO-Tube'),
                              'use_featured_image' => __('Use as movie poster', 'YOYO-Tube'),
                              'insert_into_item' => __('Insert into Movie', 'YOYO-Tube'),
                              'uploaded_to_this_item' => __('Uploaded to this Movie', 'YOYO-Tube'),
                              'items_list' => __('Movies list', 'YOYO-Tube'),
                              'items_list_navigation' => __('Movies list navigation', 'YOYO-Tube'),
                              'filter_items_list' => __('Filter Movies list', 'YOYO-Tube'),
                    );

                    $args = array(
                              'label' => __('Movie', 'YOYO-Tube'),
                              'description' => __('Custom post type for Movies', 'YOYO-Tube'),
                              'labels' => $labels,
                              'menu_icon' => 'dashicons-video-alt2',
                              'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'author', 'comments', 'custom-fields'),
                              'taxonomies' => array('genre', 'actors', 'directors'),
                              'public' => true,
                              'show_ui' => true,
                              'show_in_menu' => true,
                              'menu_position' => 5,
                              'show_in_admin_bar' => true,
                              'show_in_nav_menus' => true,
                              'can_export' => true,
                              'has_archive' => true,
                              'hierarchical' => false,
                              'exclude_from_search' => false,
                              'show_in_rest' => true,
                              'publicly_queryable' => true,
                              'capability_type' => 'post',
                    );

                    register_post_type('movies', $args);
          }
}
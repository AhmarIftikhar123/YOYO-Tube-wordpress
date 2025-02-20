<?php
/**
 * Register-Custom-Taxonomies
 * 
 * @package YOYO-Tube
 */
namespace Inc\classes;

use Inc\Traits\Singleton;

class RegisterTaxonomies
{
          use Singleton;

          public function __construct()
          {
                    $this->setup_hooks();
          }
          private function setup_hooks()
          {
                    add_action('init', [$this, 'create_genre_taxonomy']);
                    add_action('init', [$this, 'create_years_tax']);
          }
          // Register Taxonomy Genre
          function create_genre_taxonomy()
          {

                    $labels = array(
                              'name' => _x('Genres', 'taxonomy general name', 'YOYO-Tube'),
                              'singular_name' => _x('Genre', 'taxonomy singular name', 'YOYO-Tube'),
                              'search_items' => __('Search Genres', 'YOYO-Tube'),
                              'all_items' => __('All Genres', 'YOYO-Tube'),
                              'parent_item' => __('Parent Genre', 'YOYO-Tube'),
                              'parent_item_colon' => __('Parent Genre:', 'YOYO-Tube'),
                              'edit_item' => __('Edit Genre', 'YOYO-Tube'),
                              'update_item' => __('Update Genre', 'YOYO-Tube'),
                              'add_new_item' => __('Add New Genre', 'YOYO-Tube'),
                              'new_item_name' => __('New Genre Name', 'YOYO-Tube'),
                              'menu_name' => __('Genre', 'YOYO-Tube'),
                    );
                    $args = array(
                              'labels' => $labels,
                              'description' => __('Genre Movies', 'YOYO-Tube'),
                              'hierarchical' => true,
                              'public' => true,
                              'publicly_queryable' => true,
                              'show_ui' => true,
                              'show_in_menu' => true,
                              'show_in_nav_menus' => true,
                              'show_tagcloud' => true,
                              'show_in_quick_edit' => true,
                              'show_admin_column' => true,
                              'show_in_rest' => true,
                              'rewrite' => array('slug' => 'genre')
                    );
                    register_taxonomy('genre', array('movies'), $args);
          }
          // Register Taxonomy Years
          function create_years_tax()
          {

                    $labels = array(
                              'name' => _x('years', 'taxonomy general name', 'YOYO-Tube'),
                              'singular_name' => _x('Years', 'taxonomy singular name', 'YOYO-Tube'),
                              'search_items' => __('Search years', 'YOYO-Tube'),
                              'all_items' => __('All years', 'YOYO-Tube'),
                              'parent_item' => __('Parent Years', 'YOYO-Tube'),
                              'parent_item_colon' => __('Parent Years:', 'YOYO-Tube'),
                              'edit_item' => __('Edit Years', 'YOYO-Tube'),
                              'update_item' => __('Update Years', 'YOYO-Tube'),
                              'add_new_item' => __('Add New Years', 'YOYO-Tube'),
                              'new_item_name' => __('New Years Name', 'YOYO-Tube'),
                              'menu_name' => __('Years', 'YOYO-Tube'),
                    );
                    $args = array(
                              'labels' => $labels,
                              'description' => __('Movies Release Year', 'YOYO-Tube'),
                              'hierarchical' => false,
                              'public' => true,
                              'publicly_queryable' => true,
                              'show_ui' => true,
                              'show_in_menu' => true,
                              'show_in_nav_menus' => true,
                              'show_tagcloud' => true,
                              'show_in_quick_edit' => true,
                              'show_admin_column' => true,
                              'show_in_rest' => true,
                              'rewrite' => array('slug' => 'movies')

                    );
                    register_taxonomy('movie-years', array('movies'), $args);
          }
}
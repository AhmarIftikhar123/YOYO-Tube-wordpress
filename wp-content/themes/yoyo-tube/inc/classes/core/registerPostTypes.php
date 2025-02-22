<?php
namespace core;

use Inc\traits\singleton;

class RegisterPostTypes
{
          use Singleton;

          public function __construct()
          {
                    $this->setup_hooks();
          }

          public function setup_hooks()
          {
                    // Register Custom Post Type Video
                    add_action('init', [$this, 'create_video_custom_post_type']);
                    add_filter('upload_mimes', [$this,'allow_video_uploads']);
          }
          public function create_video_custom_post_type()
          {

                    $labels = array(
                              'name' => _x('Videos', 'Post Type General Name', 'YOYO-Tube'),
                              'singular_name' => _x('Video', 'Post Type Singular Name', 'YOYO-Tube'),
                              'menu_name' => _x('Videos', 'Admin Menu text', 'YOYO-Tube'),
                              'name_admin_bar' => _x('Video', 'Add New on Toolbar', 'YOYO-Tube'),
                              'archives' => __('Video Archives', 'YOYO-Tube'),
                              'attributes' => __('Video Attributes', 'YOYO-Tube'),
                              'parent_item_colon' => __('Parent Video:', 'YOYO-Tube'),
                              'all_items' => __('All Videos', 'YOYO-Tube'),
                              'add_new_item' => __('Add New Video', 'YOYO-Tube'),
                              'add_new' => __('Add New', 'YOYO-Tube'),
                              'new_item' => __('New Video', 'YOYO-Tube'),
                              'edit_item' => __('Edit Video', 'YOYO-Tube'),
                              'update_item' => __('Update Video', 'YOYO-Tube'),
                              'view_item' => __('View Video', 'YOYO-Tube'),
                              'view_items' => __('View Videos', 'YOYO-Tube'),
                              'search_items' => __('Search Video', 'YOYO-Tube'),
                              'not_found' => __('Not found', 'YOYO-Tube'),
                              'not_found_in_trash' => __('Not found in Trash', 'YOYO-Tube'),
                              'featured_image' => __('Featured Image', 'YOYO-Tube'),
                              'set_featured_image' => __('Set featured image', 'YOYO-Tube'),
                              'remove_featured_image' => __('Remove featured image', 'YOYO-Tube'),
                              'use_featured_image' => __('Use as featured image', 'YOYO-Tube'),
                              'insert_into_item' => __('Insert into Video', 'YOYO-Tube'),
                              'uploaded_to_this_item' => __('Uploaded to this Video', 'YOYO-Tube'),
                              'items_list' => __('Videos list', 'YOYO-Tube'),
                              'items_list_navigation' => __('Videos list navigation', 'YOYO-Tube'),
                              'filter_items_list' => __('Filter Videos list', 'YOYO-Tube'),
                    );
                    $args = array(
                              'label' => __('Video', 'YOYO-Tube'),
                              'description' => __('Custom Video Upload Post', 'YOYO-Tube'),
                              'labels' => $labels,
                              'menu_icon' => '',
                              'supports' => array(),
                              'taxonomies' => array(),
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
                    register_post_type('video', $args);
          }
          public function allow_video_uploads($mimes)
          {
                    $mimes['mp4'] = 'video/mp4';
                    $mimes['mov'] = 'video/quicktime';
                    $mimes['avi'] = 'video/x-msvideo';
                    $mimes['webm'] = 'video/webm';
                    return $mimes;
          }
}
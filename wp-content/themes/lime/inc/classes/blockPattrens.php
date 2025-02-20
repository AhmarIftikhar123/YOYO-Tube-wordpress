<?php
/**
 * Class for Block Pattrens
 * @package YOYO-Tube
 */
namespace Inc\classes;

use Inc\Traits\Singleton;

class blockPattrens
{
    use Singleton;

    public function __construct()
    {
        $this->setup_hooks();
    }

    public function setup_hooks()
    {
        add_action('init', [$this, 'wp_register_block_pattrens']);
        add_action('init', [$this, 'wp_register_block_pattren_catogeries']);
    }

    public function wp_register_block_pattrens()
    {
        if (function_exists('register_block_pattern')) {

            $block_content = $this->get_pattren_content('heading', 'heading_block_HTML');
            $grid_block_content = $this->get_pattren_content('grid_content', 'grid_content_HTML');
            register_block_pattern(
                "YOYO_Tube/heading_block",
                [
                    "title" => __("Heading_Block", "YOYO-Tube"),
                    "description" => __("Custom YOYO-Tube Heading Block", "YOYO-Tube"),
                    "categories" => ["Heading", 'Intro'], // Matches the registered category key
                    "content" => $block_content,
                ]
            );
            register_block_pattern(
                "YOYO_Tube/Grid_Content",
                [
                    "title" => __("Grid_Content", "YOYO-Tube"),
                    "description" => __("Custom YOYO-Tube Grid Contetn", "YOYO-Tube"),
                    "categories" => ["Grid_Content"], // Matches the registered category key
                    "content" => $grid_block_content,
                ]
            );
        }
    }

    public function wp_register_block_pattren_catogeries()
    {
        $catogeries_arr = [
            "Heading" => __("Heading_block", "YOYO-Tube"), // The key matches the block pattern category
            "Intro" => __("Intro_block", "YOYO-Tube"), // The key matches the block pattern category
            "Grid_Content" => __("Grid_Content", "YOYO-Tube"), // The key matches the block pattern category
        ];
        if (is_array($catogeries_arr) && function_exists('register_block_pattern_category')) {
            foreach ($catogeries_arr as $catogery_name => $catogery_title) {
                register_block_pattern_category($catogery_name, ['label' => $catogery_title]);
            }
        }
    }
    public function get_pattren_content(string $template_path, $template_name = '')
    {
        ob_start();
        get_template_part('template-parts/pattrens/' . $template_path, $template_name);
        return ob_get_clean();
    }
}

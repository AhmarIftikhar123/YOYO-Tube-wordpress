<?php
/**
 * Class assets
 *
 * @package Author
 * @author Ahmar Iftikhar
 *
 * This class is responsible for enqueuing all the styles and scripts for the theme.
 */
namespace Author;
use Inc\Traits\Singleton;

class Custom_author_profile
{
    use Singleton;

    public function __construct()
    {
        $this->setup_hooks();
    }

    private function setup_hooks()
    {
        add_action('wp_enqueue_scripts', [ $this, 'enqueue_author_video_links_script' ]);
        add_shortcode('debug_video_id', [ $this, 'debug_video_id_shortcode' ]);
        add_filter('the_content', [ $this, 'force_video_id_in_links' ], 999);
        add_action('pre_get_posts', [ $this, 'modify_author_query' ]);
    }

    // Override the_permalink function to include video_id
    public function override_the_permalink()
    {
        global $post;
        
        if (is_object($post) && $post->post_type === 'yoyo_videos') {
            $video_id = get_post_meta($post->ID, 'video_id', true);
            $permalink = get_permalink($post->ID);
            
            if (!empty($video_id)) {
                $permalink = add_query_arg('video_id', $video_id, $permalink);
                echo esc_url($permalink);
                return;
            }
        }
        
        // Default behavior
        the_permalink();
    }

    // Debug function to check if video_id is being retrieved correctly
    public function debug_video_id($post_id)
    {
        $video_id = get_post_meta($post_id, 'video_id', true);
        if (!empty($video_id)) {
            echo "<!-- Debug: Video ID for post $post_id is $video_id -->";
        } else {
            echo "<!-- Debug: No Video ID found for post $post_id -->";
        }
    }

    // Enqueue the author video links script
    public function enqueue_author_video_links_script()
    {
        if (is_author()) {
            wp_enqueue_script('author-video-links', get_template_directory_uri() . '/src/js/author-video-links.js', ['jquery'], '1.0.0', true);
        }
    }

    // Shortcode to debug video_id
    public function debug_video_id_shortcode($atts)
    {
        global $post;
        
        if (!is_object($post)) {
            return '<!-- No post object available -->';
        }
        
        $video_id = get_post_meta($post->ID, 'video_id', true);
        
        if (!empty($video_id)) {
            return "<!-- Debug: Video ID for post {$post->ID} is {$video_id} -->";
        } else {
            return "<!-- Debug: No Video ID found for post {$post->ID} -->";
        }
    }

    // Force video_id parameter in all video links
    public function force_video_id_in_links($content)
    {
        global $post;
        
        if (!is_object($post) || $post->post_type !== 'yoyo_videos') {
            return $content;
        }
        
        $video_id = get_post_meta($post->ID, 'video_id', true);
        
        if (empty($video_id)) {
            return $content;
        }
        
        // Use DOMDocument to modify links
        if (function_exists('libxml_use_internal_errors')) {
            libxml_use_internal_errors(true); // Suppress warnings for malformed HTML
            
            $dom = new \DOMDocument();
            $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
            
            $links = $dom->getElementsByTagName('a');
            
            foreach ($links as $link) {
                $href = $link->getAttribute('href');
                
                // Skip if already has video_id
                if (strpos($href, 'video_id=') !== false) {
                    continue;
                }
                
                // Add video_id parameter
                $href = add_query_arg('video_id', $video_id, $href);
                $link->setAttribute('href', $href);
            }
            
            $content = $dom->saveHTML();
            libxml_clear_errors();
        }
        
        return $content;
    }

    // Fix author pagination issue
    public function modify_author_query($query)
    {
        if ($query->is_author() && $query->is_main_query()) {
            $query->set('post_type', ['yoyo_videos', 'post']);
        }
    }
}

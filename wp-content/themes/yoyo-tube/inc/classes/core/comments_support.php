<?php
/**
 * Class Comments_support
 *
 * Handles comment functionality, ensuring video_id is properly stored and retrieved.
 *
 * @package Core
 * @author Ahmar Iftikhar
 */

namespace Core;

use Inc\Traits\Singleton;

class Comments_support {
    use Singleton;

    public function __construct() {
        $this->setup_hooks();
    }

    private function setup_hooks() {
        add_action('comment_post', [$this, 'save_video_id_with_comment']);
        add_filter('get_comment_link', [$this, 'add_video_id_to_comment_permalink'], 10, 2);
        add_filter('manage_edit-comments_columns', [$this, 'add_video_id_column_to_comments']);
        add_action('manage_comments_custom_column', [$this, 'fill_video_id_column'], 10, 2);
    }
    /**
     * Save video_id as comment meta when a comment is submitted.
     */
    public function save_video_id_with_comment($comment_id) {
        if (isset($_POST['yoyo_video_id']) && !empty($_POST['yoyo_video_id'])) {
            add_comment_meta($comment_id, 'video_id', sanitize_text_field($_POST['yoyo_video_id']));
        }
    }

    /**
     * Ensure video_id is included in comment permalinks.
     */
    public function add_video_id_to_comment_permalink($permalink, $comment) {
        $video_id = get_comment_meta($comment->comment_ID, 'video_id', true);
        if (empty($video_id)) {
            $video_id = get_post_meta($comment->comment_post_ID, 'video_id', true);
        }

        if (!empty($video_id) && strpos($permalink, 'video_id=') === false) {
            $permalink = add_query_arg('video_id', $video_id, $permalink);
        }

        return $permalink;
    }

    /**
     * Add video_id column in comment admin panel.
     */
    public function add_video_id_column_to_comments($columns) {
        $columns['video_id'] = __('Video ID', 'YOYO-Tube');
        return $columns;
    }

    /**
     * Fill video_id column in the comment admin panel.
     */
    public function fill_video_id_column($column, $comment_id) {
        if ($column === 'video_id') {
            $video_id = get_comment_meta($comment_id, 'video_id', true);
            echo $video_id ? esc_html($video_id) : '—';
        }
    }
}

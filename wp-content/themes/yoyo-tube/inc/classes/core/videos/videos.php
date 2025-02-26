<?php
namespace Videos;
use Inc\traits\singleton;

class Videos
{
    use Singleton;

    public function __construct()
    {
        $this->setup_hooks();
    }

    public function setup_hooks()
    {
        add_action('wp_ajax_yoyo_handle_video_upload', [$this, 'yoyo_handle_video_upload']);
        add_action('wp_ajax_nopriv_yoyo_handle_video_upload', [$this, 'yoyo_handle_video_upload']);
    }

    public function yoyo_handle_video_upload()
    {
        if (!is_user_logged_in()) {
            wp_send_json_error("You must be logged in to upload a video.");
        }

        if (!isset($_FILES['video_file'])) {
            wp_send_json_error("No video file uploaded.");
        }

        // Handle upload
        $file = $_FILES['video_file'];
        $upload_overrides = ['test_form' => false];
        $uploaded_video = wp_handle_upload($file, $upload_overrides);

        if (isset($uploaded_video['error'])) {
            wp_send_json_error($uploaded_video['error']);
        }

        // Save as a post of type 'yoyo_videos'
        $video_title = sanitize_text_field($_POST['video_title']);
        $video_desc = sanitize_textarea_field($_POST['video_desc']);

        $video_post = [
            'post_title' => $video_title,
            'post_content' => $video_desc,
            'post_status' => 'publish',
            'post_type' => 'yoyo_videos',
        ];

        $post_id = wp_insert_post($video_post);

        if ($post_id) {
            // Save video URL in post meta
            update_post_meta($post_id, 'video_url', $uploaded_video['url']);
            // Get the WordPress upload directory
            $upload_dir = wp_upload_dir();
            $video_path = $uploaded_video['file']; // Absolute path
            $video_url = $uploaded_video['url'];   // URL

            // Create attachment post
            $attachment = [
                'guid' => $video_url,
                'post_mime_type' => $file['type'],
                'post_title' => basename($video_path),
                'post_content' => '',
                'post_status' => 'inherit'
            ];

            // Insert attachment into wp_posts
            $attach_id = wp_insert_attachment($attachment, $video_path);

            // Generate metadata for the attachment
            require_once ABSPATH . 'wp-admin/includes/image.php';
            $attach_data = wp_generate_attachment_metadata($attach_id, $video_path);
            wp_update_attachment_metadata($attach_id, $attach_data);

            // Attach video to the video post
            update_post_meta($post_id, '_thumbnail_id', $attach_id);


            wp_send_json_success("Video uploaded successfully!");
        } else {
            wp_send_json_error("Failed to create video post.");
        }
    }
}
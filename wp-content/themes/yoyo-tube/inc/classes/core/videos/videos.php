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

    public function extract_video_thumbnail($video_path, $thumbnail_path, $time = 1)
    {
        if (!file_exists($video_path)) {
            return false;
        }

        $cmd = "ffmpeg -i {$video_path} -ss {$time} -vframes 1 {$thumbnail_path} 2>&1";
        exec($cmd, $output, $return_var);

        return $return_var === 0 ? $thumbnail_path : false;
    }

    public function yoyo_handle_video_upload()
    {
        $this->verify_request();
        $file = $_FILES['video_file'];
        $upload_dir = wp_upload_dir();        
        $uploaded_video = $this->handle_file_upload($file);
        if (!$uploaded_video) {
            return;
        }
        
        $video_path = $uploaded_video['file'];
        $thumbnail_path = $this->generate_thumbnail($video_path, $upload_dir);
        
        $post_id = $this->create_video_post($uploaded_video, $thumbnail_path);
        if ($post_id) {
            $this->attach_media($uploaded_video, $post_id);
            wp_send_json_success(['message' => "Video uploaded successfully!"]);
        } else {
            wp_send_json_error(['message' => "Failed to create video post."]);
        }
    }

    private function verify_request()
    {
        check_ajax_referer('yoyo-video-upload', 'security');
        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => "You must be logged in to upload a video."]);
        }
        
        $this->validate_video_upload();
    }

    private function validate_video_upload()
    {
        $required_fields = ['video_title', 'video_description', 'video_tags', 'video_category'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                wp_send_json_error(['message' => "Please enter a valid {$field}."]);
            }
        }
        
        if (!isset($_FILES['video_file']) || empty($_FILES['video_file']['name'])) {
            wp_send_json_error(['message' => "No video file uploaded."]);
        }
        
        $tags_array = explode(',', sanitize_text_field($_POST['video_tags']));
        if (count($tags_array) < 3) {
            wp_send_json_error(['message' => "Please enter at least 3 tags."]);
        }
    }

    private function handle_file_upload($file)
    {
        $upload_overrides = ['test_form' => false];
        $uploaded_video = wp_handle_upload($file, $upload_overrides);
        
        if (isset($uploaded_video['error'])) {
            wp_send_json_error(['message' => $uploaded_video['error']]);
            return false;
        }
        
        return $uploaded_video;
    }

    private function generate_thumbnail($video_path, $upload_dir)
    {
        $thumbnail_path = $upload_dir['basedir'] . '/thumbnails/' . basename($video_path) . '.jpg';
        if (!file_exists($upload_dir['basedir'] . '/thumbnails/')) {
            mkdir($upload_dir['basedir'] . '/thumbnails/', 0755, true);
        }
        
        return $this->extract_video_thumbnail($video_path, $thumbnail_path);
    }


    private function create_video_post($uploaded_video, $thumbnail)
    {
        $video_post = [
            'post_title'   => sanitize_text_field($_POST['video_title']),
            'post_content' => sanitize_textarea_field($_POST['video_description']),
            'post_status'  => 'publish',
            'post_type'    => 'yoyo_videos',
        ];

        $post_id = wp_insert_post($video_post);
        if (!$post_id) {
            return false;
        }

        update_post_meta($post_id, 'video_url', $uploaded_video['url']);
        if ($thumbnail) {
            $thumbnail = str_replace('/var/www/html', '', $thumbnail);
            update_post_meta($post_id, 'thumbnail_url', esc_url_raw($thumbnail));
        }
        
        update_post_meta($post_id, 'video_category', sanitize_text_field($_POST['video_category']));

        update_post_meta($post_id, 'video_link', esc_url_raw(home_url('/video-player/?video_id=' . $post_id)));

        $is_paid = isset($_POST['is_paid']);
        update_post_meta($post_id, 'is_paid', $is_paid);
        if ($is_paid) {
            update_post_meta($post_id, 'video_price', floatval($_POST['video_price']));
        }
        
        wp_set_post_terms($post_id, explode(',', sanitize_text_field($_POST['video_tags'])), 'post_tag');
        $this->set_video_category($post_id);

        return $post_id;
    }

    private function set_video_category($post_id)
    {
        $category_term = term_exists($_POST['video_category'], 'category');
        if (!$category_term) {
            $category_term = wp_insert_term($_POST['video_category'], 'category');
        }
        if (!is_wp_error($category_term)) {
            wp_set_post_terms($post_id, [$category_term['term_id']], 'category');
        }
    }

    private function attach_media($uploaded_video, $post_id)
    {
        $attachment = [
            'guid'           => $uploaded_video['url'],
            'post_mime_type' => $_FILES['video_file']['type'],
            'post_title'     => basename($uploaded_video['file']),
            'post_content'   => '',
            'post_status'    => 'inherit'
        ];

        $attach_id = wp_insert_attachment($attachment, $uploaded_video['file'], $post_id);
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $attach_data = wp_generate_attachment_metadata($attach_id, $uploaded_video['file']);
        wp_update_attachment_metadata($attach_id, $attach_data);
        $is_updated = update_post_meta($post_id, '_thumbnail_id', $attach_id);
        if (!$is_updated) {
            wp_send_json_error(['message' => "Failed to attach media."]);
        }
    }
}

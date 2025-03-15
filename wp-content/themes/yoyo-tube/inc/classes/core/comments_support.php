<?php
/**
 * Class Comments_support
 *
 * Handles comment redirection and pagination to ensure video_id is preserved.
 *
 * @package Core
 * @author Ahmar Iftikhar
 */

 namespace Core;

 use Inc\Traits\Singleton;
 
 class Comments_support
 {
     use Singleton;
 
     public function __construct()
     {
         $this->setup_hooks();
     }
 
     private function setup_hooks()
     {
         // Preserve video_id after submitting a comment
         add_filter('comment_post_redirect', [$this, 'custom_comment_redirect'], 10, 2);
 
         // Preserve video_id in comment pagination links
         add_filter('paginate_comments_links', [$this, 'add_video_id_to_comment_pagination']);
 
         // Ensure video_id is added to the comment form
         add_action('comment_form', [$this, 'add_video_id_to_comment_form']);
     }
 
     /**
      * Modify the redirect URL after posting a comment to include video_id.
      */
     public function custom_comment_redirect($location, $comment)
     {
         if (!empty($_POST['video_id'])) {
             $video_id = intval($_POST['video_id']);
             $location = site_url('/video-player/?video_id=' . $video_id . '#comment-' . $comment->comment_ID);
         }
         return $location;
     }
 
     /**
      * Modify pagination links to preserve video_id.
      */
/**
 * Modify pagination links to preserve video_id.
 */
/**
 * Add video_id to comment pagination links.
 */
public function add_video_id_to_comment_pagination($args)
{
    if (!isset($_GET['video_id']) || empty($_GET['video_id'])) {
        return $args; // No video_id, return original args
    }

    $video_id = intval($_GET['video_id']);

    // Ensure 'add_args' is set correctly
    if (!isset($args['add_args']) || !is_array($args['add_args'])) {
        $args['add_args'] = [];
    }

    // Add video_id to pagination args
    $args['add_args']['video_id'] = $video_id;

    return $args;
}

 
     /**
      * Add a hidden video_id field to the comment form.
      */
     public function add_video_id_to_comment_form()
     {
         if (!empty($_GET['video_id'])) {
             echo '<input type="hidden" name="video_id" value="' . esc_attr($_GET['video_id']) . '">';
         }
     }
 }
 
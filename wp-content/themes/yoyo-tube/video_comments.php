<?php
/**
 * The template for displaying comments
 *
 * @package YOYO-Tube
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Don't load comments if password protected
if (post_password_required()) {
    return;
}

// Get video_id from URL or post meta
$video_id = isset($_GET['video_id']) ? sanitize_text_field($_GET['video_id']) : '';
if (empty($video_id)) {
    $video_id = get_post_meta(get_the_ID(), 'video_id', true);
}
?>

<div id="comments" class="video-comments">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            printf(
                esc_html(_n('%1$s Comment', '%1$s Comments', $comment_count, 'YOYO-Tube')),
                number_format_i18n($comment_count)
            );
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 50,
            ));
            ?>
        </ol>

        <?php
        // Comment pagination
        the_comments_pagination(array(
            'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('Previous', 'YOYO-Tube'),
            'next_text' => __('Next', 'YOYO-Tube') . ' <i class="fas fa-chevron-right"></i>',
        ));
        ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'YOYO-Tube'); ?></p>
    <?php endif; ?>

    <?php
    // Custom comment form with video_id
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    
    $fields = array(
        'author' => '<div class="comment-form-author form-group">' .
                    '<label for="author">' . __('Name', 'YOYO-Tube') . ($req ? ' <span class="required">*</span>' : '') . '</label>' .
                    '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" ' . $aria_req . ' class="form-control" />' .
                    '</div>',
        'email'  => '<div class="comment-form-email form-group">' .
                    '<label for="email">' . __('Email', 'YOYO-Tube') . ($req ? ' <span class="required">*</span>' : '') . '</label>' .
                    '<input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" ' . $aria_req . ' class="form-control" />' .
                    '</div>',
        'url'    => '<div class="comment-form-url form-group">' .
                    '<label for="url">' . __('Website', 'YOYO-Tube') . '</label>' .
                    '<input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" class="form-control" />' .
                    '</div>',
    );

    // Add hidden field inside comment_field to ensure it gets included in the form
    $comment_field = '<div class="comment-form-comment form-group">' .
                     '<label for="comment">' . __('Comment', 'YOYO-Tube') . ' <span class="required">*</span></label>' .
                     '<textarea id="comment" name="comment" class="form-control" rows="5" required="required"></textarea>' .
                     '</div>';

    if (!empty($video_id)) {
        $comment_field .= '<input type="hidden" name="yoyo_video_id" value="' . esc_attr($video_id) . '">';
    }

    $comments_args = array(
        'fields'               => $fields,
        'comment_field'        => $comment_field,
        'class_submit'         => 'submit btn btn-primary',
        'title_reply'          => __('Leave a Comment', 'YOYO-Tube'),
        'title_reply_to'       => __('Reply to %s', 'YOYO-Tube'),
        'cancel_reply_link'    => __('Cancel Reply', 'YOYO-Tube'),
        'label_submit'         => __('Post Comment', 'YOYO-Tube'),
        'format'               => 'html5',
    );

    comment_form($comments_args);
    ?>
</div>

<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package YOYO-Tube
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            printf(
                _nx(
                    '%1$s Comment',
                    '%1$s Comments',
                    $comments_number,
                    'comments title',
                    'YOYO-Tube'
                ),
                number_format_i18n($comments_number)
            );
            ?>
        </h2>

        <div class="comment-list">
            <?php
            wp_list_comments(array(
                'style' => 'div',
                'short_ping' => true,
                'avatar_size' => 50,
                'callback' => 'yoyo_custom_comment'
            ));
            ?>
        </div>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav class="comment-navigation">
                <div class="nav-previous"><?php previous_comments_link(__('Older Comments', 'yoyo-tube')); ?></div>
                <div class="nav-next"><?php next_comments_link(__('Newer Comments', 'yoyo-tube')); ?></div>
            </nav>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php _e('Comments are closed.', 'yoyo-tube'); ?></p>
    <?php endif; ?>

    <?php
    // Preserve video_id in comment form
    $video_id = isset($_GET['video_id']) ? $_GET['video_id'] : '';
    $comments_args = array(
        'title_reply' => __('Leave a Comment', 'yoyo-tube'),
        'class_form' => 'comment-form',
        'comment_field' => '<div class="comment-form-comment">
                            <label for="comment">' . _x('Comment', 'noun') . '</label>
                            <textarea id="comment" name="comment" rows="5" required></textarea>
                          </div>',
        'submit_button' => '<button type="submit" name="submit" class="btn-primary">Post Comment</button>',
        'submit_field' => '<div class="form-submit">%1$s %2$s</div>',
        'fields' => array(
            'url' => '', // Remove website field
        ),
    );

    // Add hidden input for video_id
    add_action('comment_form', function() use ($video_id) {
        echo '<input type="hidden" name="video_id" value="' . esc_attr($video_id) . '">';
    });

    comment_form($comments_args);
    ?>
</div>
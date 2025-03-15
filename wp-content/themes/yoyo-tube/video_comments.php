<?php
/**
 * The template for displaying comments
 *
 * @package YOYO-Tube
 */

if (post_password_required()) {
    return;
}

// Get the video ID from the URL
$video_id = isset($_GET['video_id']) ? intval($_GET['video_id']) : 0;
$video_url = $video_id ? wp_get_attachment_url($video_id) : '';
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            printf(
                _nx('%1$s Comment', '%1$s Comments', $comments_number, 'comments title', 'YOYO-Tube'),
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
                <div class="nav-previous">
                    <?php 
                    ob_start();
                    previous_comments_link(__('Older Comments', 'yoyo-tube'));
                    $prev_link = ob_get_clean();

                    if ($video_id) {
                        $prev_link = preg_replace_callback(
                            '/href=["\']([^"\']+)["\']/i',
                            function ($matches) use ($video_id) {
                                $url_parts = parse_url($matches[1]);
                                $host = isset($url_parts['port']) ? $url_parts['host'] . ':' . $url_parts['port'] : $url_parts['host'];
                                $query = isset($url_parts['query']) ? $url_parts['query'] . '&video_id=' . $video_id : 'video_id=' . $video_id;
                                $new_url = $url_parts['scheme'] . '://' . $host . $url_parts['path'] . '?' . $query;

                                if (isset($url_parts['fragment'])) {
                                    $new_url .= '#' . $url_parts['fragment'];
                                }
                                return 'href="' . esc_url($new_url) . '"';
                            },
                            $prev_link
                        );
                    }
                    echo $prev_link;
                    ?>
                </div>
                <div class="nav-next">
                    <?php 
                    ob_start();
                    next_comments_link(__('Newer Comments', 'yoyo-tube'));
                    $next_link = ob_get_clean();

                    if ($video_id) {
                        $next_link = preg_replace_callback(
                            '/href=["\']([^"\']+)["\']/i',
                            function ($matches) use ($video_id) {
                                $url_parts = parse_url($matches[1]);
                                $host = isset($url_parts['port']) ? $url_parts['host'] . ':' . $url_parts['port'] : $url_parts['host'];
                                $query = isset($url_parts['query']) ? $url_parts['query'] . '&video_id=' . $video_id : 'video_id=' . $video_id;
                                $new_url = $url_parts['scheme'] . '://' . $host . $url_parts['path'] . '?' . $query;

                                if (isset($url_parts['fragment'])) {
                                    $new_url .= '#' . $url_parts['fragment'];
                                }
                                return 'href="' . esc_url($new_url) . '"';
                            },
                            $next_link
                        );
                    }
                    echo $next_link;
                    ?>
                </div>
            </nav>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php _e('Comments are closed.', 'yoyo-tube'); ?></p>
    <?php endif; ?>

    <?php
    // Comment form settings
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

    // Preserve video_id in the comment form
    add_action('comment_form_after_fields', function() use ($video_id) {
        if ($video_id) {
            echo '<input type="hidden" name="video_id" value="' . esc_attr($video_id) . '">';
        }
    });

    comment_form($comments_args);
    ?>

</div>

<?php
// Ensure video_id is passed to the comment form
add_action('comment_form_after_fields', function() {
    if (isset($_GET['video_id'])) {
        echo '<input type="hidden" name="video_id" value="' . esc_attr($_GET['video_id']) . '">';
    }
});
?>

<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package YOYO-Tube
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if (post_password_required()) {
          return;
}
?>

<div id="comments" class="comments-area">
          <h2 class="comments-title">
                    <?php
                    printf(
                              _nx(
                                        'One thought on "%2$s"',
                                        '%1$s thoughts on "%2$s"',
                                        get_comments_number(),
                                        'comments title',
                                        'YOYO-Tube'
                              ),
                              number_format_i18n(get_comments_number()),
                              '<span>' . get_the_title() . '</span>'
                    );
                    ?>
          </h2>

          <?php if (have_comments()): ?>
                    <ul class="comment-list">
                              <?php
                              wp_list_comments(
                                        array(
                                                  'style' => 'ul',
                                                  'short_ping' => true,
                                                  'avatar_size' => 50
                                        )
                              );
                              ?>
                    </ul>
          <?php else: ?>
                    <p class="no-comments">No comments yet. Be the first to share your thoughts!</p>
          <?php endif; ?>
          <?php if (get_comment_pages_count() > 1 && get_option('page_comments')): ?>

                    <nav class="navigation comment-navigation" role="navigation">

                              <h3 class="screen-reader-text section-heading">
                                        <?php _e('Comment navigation', 'YOYO-Tube'); ?>
                              </h3>
                              <div class="nav-previous">
                                        <?php previous_comments_link(__('&larr; Older Comments', 'YOYO-Tube')); ?>
                              </div>
                              <div class="nav-next">
                                        <?php next_comments_link(__('Newer Comments &rarr;', 'YOYO-Tube')); ?>
                              </div>

                    </nav><!-- .comment-navigation -->

          <?php endif; // Check for comment navigation ?>
          <?php if (!comments_open() && get_comments_number()): ?>
                    <p class="no-comments"><?php _e('Comments are closed.', 'twentythirteen'); ?></p>
          <?php endif; ?>
                    <?php comment_form() ?>
</div>
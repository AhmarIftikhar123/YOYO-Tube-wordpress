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

	<?php
	// You can start editing here -- including this comment!
	if (have_comments()):
		?>
		<h2 class="comments-title">
			<?php
			$yoyo_tube_comment_count = get_comments_number();
			if ('1' === $yoyo_tube_comment_count) {
				printf(
					/* translators: 1: title. */
					esc_html__('One thought on &ldquo;%1$s&rdquo;', 'yoyo-tube'),
					'<span>' . wp_kses_post(get_the_title()) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $yoyo_tube_comment_count, 'comments title', 'yoyo-tube')),
					number_format_i18n($yoyo_tube_comment_count), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post(get_the_title()) . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style' => 'ol',
					'short_ping' => true,
					'avatar_size' => 40,
					'class' => 'rounded-circle',
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		$video_id = isset($_GET['video_id']) ? $_GET['video_id'] : '';

		$prev_link = get_previous_comments_link(__('Older Comments'));
		$next_link = get_next_comments_link(__('Newer Comments'));

		if ($prev_link || $next_link): ?>
			<nav class="comment-navigation">
				<ul class="pagination">
					<?php if ($prev_link): ?>
						<li class="prev">
							<?php echo str_replace('#comments', '?video_id=' . esc_attr($video_id) . '#comments', $prev_link); ?>
						</li>
					<?php endif; ?>
					<?php if ($next_link): ?>
						<li class="next">
							<?php echo str_replace('#comments', '?video_id=' . esc_attr($video_id) . '#comments', $next_link); ?>
						</li>
					<?php endif; ?>
				</ul>
			</nav>
			 <!-- If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) : -->
			<p class="no-comments"><?php esc_html_e('Comments are closed.', 'yoyo-tube'); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().
	
	comment_form();
	?>

</div><!-- #comments -->
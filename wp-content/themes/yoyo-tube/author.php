<?php
/**
 * The template for displaying author pages
 *
 * @package YOYO-Tube
 */

get_header();

// Get author information
$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
$author_id = $curauth->ID;

// Get active tab from URL parameter or default to 'uploads'
$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'uploads';

// Get current page for pagination
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
if (empty($paged)) {
    // Try to get from query string as fallback
    $paged = (isset($_GET['paged'])) ? absint($_GET['paged']) : 1;
}

// Get author meta
$author_bio = get_the_author_meta('description', $author_id);
$author_website = get_the_author_meta('user_url', $author_id);
$author_registered = date('F Y', strtotime($curauth->user_registered));
$author_videos_count = count_user_posts($author_id, 'yoyo_videos');

// Get social media links if they exist
$twitter = get_the_author_meta('twitter', $author_id);
$facebook = get_the_author_meta('facebook', $author_id);
$instagram = get_the_author_meta('instagram', $author_id);
$youtube = get_the_author_meta('youtube', $author_id);
?>

<div class="author-profile-container">
    <div class="author-header">
        <div class="author-avatar">
            <?php echo get_avatar($author_id, 150, '', $curauth->display_name, array('class' => 'author-avatar-img')); ?>
        </div>
        <div class="author-info">
            <h1 class="author-name"><?php echo esc_html($curauth->display_name); ?></h1>
            
            <?php if (!empty($author_bio)) : ?>
                <div class="author-bio">
                    <?php echo wpautop(esc_html($author_bio)); ?>
                </div>
            <?php endif; ?>
            
            <div class="author-meta">
                <div class="author-meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Member since <?php echo esc_html($author_registered); ?></span>
                </div>
                
                <?php if (!empty($author_website)) : ?>
                    <div class="author-meta-item">
                        <i class="fas fa-globe"></i>
                        <a href="<?php echo esc_url($author_website); ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo esc_html(preg_replace("(^https?://)", "", $author_website)); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <div class="author-meta-item">
                    <i class="fas fa-video"></i>
                    <span><?php echo esc_html($author_videos_count); ?> videos</span>
                </div>
            </div>
            
            <?php if (!empty($twitter) || !empty($facebook) || !empty($instagram) || !empty($youtube)) : ?>
                <div class="author-social">
                    <?php if (!empty($twitter)) : ?>
                        <a href="<?php echo esc_url($twitter); ?>" class="social-icon" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-twitter"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if (!empty($facebook)) : ?>
                        <a href="<?php echo esc_url($facebook); ?>" class="social-icon" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-facebook"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if (!empty($instagram)) : ?>
                        <a href="<?php echo esc_url($instagram); ?>" class="social-icon" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-instagram"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if (!empty($youtube)) : ?>
                        <a href="<?php echo esc_url($youtube); ?>" class="social-icon" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-youtube"></i>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="author-content">
        <ul class="nav nav-tabs author-tabs" id="authorTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo $active_tab === 'uploads' ? 'active' : ''; ?>" 
                   id="uploads-tab" 
                   href="<?php echo esc_url(add_query_arg('tab', 'uploads', remove_query_arg('paged'))); ?>" 
                   role="tab" 
                   aria-controls="uploads" 
                   aria-selected="<?php echo $active_tab === 'uploads' ? 'true' : 'false'; ?>">
                    <i class="fas fa-upload"></i> Uploads
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo $active_tab === 'purchased' ? 'active' : ''; ?>" 
                   id="purchased-tab" 
                   href="<?php echo esc_url(add_query_arg('tab', 'purchased', remove_query_arg('paged'))); ?>" 
                   role="tab" 
                   aria-controls="purchased" 
                   aria-selected="<?php echo $active_tab === 'purchased' ? 'true' : 'false'; ?>">
                    <i class="fas fa-shopping-cart"></i> Purchased
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo $active_tab === 'comments' ? 'active' : ''; ?>" 
                   id="comments-tab" 
                   href="<?php echo esc_url(add_query_arg('tab', 'comments', remove_query_arg('paged'))); ?>" 
                   role="tab" 
                   aria-controls="comments" 
                   aria-selected="<?php echo $active_tab === 'comments' ? 'true' : 'false'; ?>">
                    <i class="fas fa-comments"></i> Comments
                </a>
            </li>
        </ul>
        
        <div class="tab-content" id="authorTabContent">
            <?php if ($active_tab === 'uploads') : ?>
                <div class="tab-pane fade show active" id="uploads" role="tabpanel" aria-labelledby="uploads-tab">
                    <?php
                    // Query videos uploaded by author
                    $uploads_args = array(
                        'post_type' => 'yoyo_videos',
                        'posts_per_page' => 5,
                        'author' => $author_id,
                        'paged' => $paged
                    );
                    
                    $uploads_query = new WP_Query($uploads_args);
                    
                    if ($uploads_query->have_posts()) :
                    ?>
                        <div class="video-grid author-videos-grid">
                            <?php
                            while ($uploads_query->have_posts()) :
                                $uploads_query->the_post();
                                get_template_part('template-parts/content', 'author-video');
                            endwhile;
                            ?>
                        </div>
                        
                        <div class="author-pagination">
                            <?php
                            // Create custom pagination links that preserve the tab parameter
                            $pagination_args = array(
                                'base' => add_query_arg('paged', '%#%'),
                                'format' => '',
                                'prev_text' => __('&laquo; Previous'),
                                'next_text' => __('Next &raquo;'),
                                'total' => $uploads_query->max_num_pages,
                                'current' => $paged,
                                'add_args' => array('tab' => $active_tab) // This preserves the tab parameter
                            );
                            
                            echo paginate_links($pagination_args);
                            ?>
                        </div>
                        
                        <?php wp_reset_postdata(); ?>
                        
                    <?php else : ?>
                        <div class="no-content-message">
                            <i class="fas fa-video-slash"></i>
                            <h3>No Videos Uploaded</h3>
                            <p><?php echo esc_html($curauth->display_name); ?> hasn't uploaded any videos yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($active_tab === 'purchased') : ?>
                <div class="tab-pane fade show active" id="purchased" role="tabpanel" aria-labelledby="purchased-tab">
                    <?php
                    // Get purchased videos IDs from user meta
                    $purchased_video_ids = get_user_meta($author_id, 'purchased_videos', true);
                    
                    if (!empty($purchased_video_ids) && is_array($purchased_video_ids)) {
                        // Query purchased videos
                        $purchased_args = array(
                            'post_type' => 'yoyo_videos',
                            'posts_per_page' => 12,
                            'post__in' => $purchased_video_ids,
                            'paged' => $paged
                        );
                        
                        $purchased_query = new WP_Query($purchased_args);
                        
                        if ($purchased_query->have_posts()) :
                        ?>
                            <div class="video-grid author-videos-grid">
                                <?php
                                while ($purchased_query->have_posts()) :
                                    $purchased_query->the_post();
                                    get_template_part('template-parts/content', 'author-video');
                                endwhile;
                                ?>
                            </div>
                            
                            <div class="author-pagination">
                                <?php
                                // Create custom pagination links that preserve the tab parameter
                                $pagination_args = array(
                                    'base' => add_query_arg('paged', '%#%'),
                                    'format' => '',
                                    'prev_text' => __('&laquo; Previous'),
                                    'next_text' => __('Next &raquo;'),
                                    'total' => $purchased_query->max_num_pages,
                                    'current' => $paged,
                                    'add_args' => array('tab' => $active_tab) // This preserves the tab parameter
                                );
                                
                                echo paginate_links($pagination_args);
                                ?>
                            </div>
                            
                            <?php wp_reset_postdata(); ?>
                            
                        <?php else : ?>
                            <div class="no-content-message">
                                <i class="fas fa-shopping-cart"></i>
                                <h3>No Purchased Videos</h3>
                                <p><?php echo esc_html($curauth->display_name); ?> hasn't purchased any videos yet.</p>
                            </div>
                        <?php endif; ?>
                    <?php } else { ?>
                        <div class="no-content-message">
                            <i class="fas fa-shopping-cart"></i>
                            <h3>No Purchased Videos</h3>
                            <p><?php echo esc_html($curauth->display_name); ?> hasn't purchased any videos yet.</p>
                        </div>
                    <?php } ?>
                </div>
            <?php endif; ?>
            
            <?php if ($active_tab === 'comments') : ?>
                <div class="tab-pane fade show active" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                    <?php
                    // Calculate offset for comment pagination
                    $comments_per_page = 20;
                    $offset = ($paged - 1) * $comments_per_page;
                    
                    // Query comments by author
                    $comments_args = array(
                        'user_id' => $author_id,
                        'status' => 'approve',
                        'number' => $comments_per_page,
                        'offset' => $offset
                    );
                    
                    $comments_query = new WP_Comment_Query;
                    $comments = $comments_query->query($comments_args);
                    
                    if ($comments) :
                    ?>
                        <div class="author-comments-list">
                            <?php foreach ($comments as $comment) : 
                                // Get post information
                                $post_id = $comment->comment_post_ID;
                                $post_type = get_post_type($post_id);
                                
                                // Get the video_id for this comment's post
                                $video_id = $post_id;

                                

                                var_dump($video_id);




                                // Build the comment URL with video_id
                                $comment_url = get_permalink($post_id);
                                if (!empty($video_id) && $post_type === 'yoyo_videos') {
                                    // Force add video_id parameter
                                    $comment_url = add_query_arg('video_id', $video_id, $comment_url);
                                }
                                
                                // Add the comment anchor
                                $comment_url .= '#comment-' . $comment->comment_ID;
                            ?>
                                <div class="author-comment-item">
                                    <div class="comment-meta">
                                        <a href="<?php echo esc_url($comment_url); ?>" class="comment-post-title">
                                            <?php echo esc_html(get_the_title($post_id)); ?>
                                            <?php if (!empty($video_id)) : ?>
                                                <span class="video-id-debug" style="display: none;">Video ID: <?php echo esc_html($video_id); ?></span>
                                            <?php endif; ?>
                                        </a>
                                        <span class="comment-date">
                                            <i class="fas fa-calendar-alt"></i>
                                            <?php echo esc_html(human_time_diff(strtotime($comment->comment_date), current_time('timestamp'))); ?> ago
                                        </span>
                                    </div>
                                    <div class="comment-content">
                                        <?php echo wpautop(esc_html($comment->comment_content)); ?>
                                    </div>
                                    <div class="comment-actions">
                                        <a href="<?php echo esc_url($comment_url); ?>" class="view-comment-link">
                                            <i class="fas fa-eye"></i> View in context
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="author-pagination">
                            <?php
                            // Get total comments for pagination
                            $total_comments = get_comments(array(
                                'user_id' => $author_id,
                                'status' => 'approve',
                                'count' => true
                            ));
                            
                            $total_pages = ceil($total_comments / $comments_per_page);
                            
                            // Create custom pagination links that preserve the tab parameter
                            $pagination_args = array(
                                'base' => add_query_arg('paged', '%#%'),
                                'format' => '',
                                'prev_text' => __('&laquo; Previous'),
                                'next_text' => __('Next &raquo;'),
                                'total' => $total_pages,
                                'current' => $paged,
                                'add_args' => array('tab' => $active_tab) // This preserves the tab parameter
                            );
                            
                            echo paginate_links($pagination_args);
                            ?>
                        </div>
                    <?php else : ?>
                        <div class="no-content-message">
                            <i class="fas fa-comments-slash"></i>
                            <h3>No Comments</h3>
                            <p><?php echo esc_html($curauth->display_name); ?> hasn't made any comments yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>


<div class="video-grid">
        <?php


        if ($video_query->have_posts()) :
            while ($video_query->have_posts()) : $video_query->the_post();
                $video_url = get_post_meta(get_the_ID(), 'video_url', true);
                $is_paid = get_post_meta(get_the_ID(), 'is_paid', true);
                $video_price = get_post_meta(get_the_ID(), 'video_price', true);
        ?>
                <div class="video-item">
                    <div class="video-thumbnail">
                        <video width="100%" height="auto" controls>
                            <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <h2 class="video-title"><?php the_title(); ?></h2>
                    <div class="video-meta">
                        <span class="video-date"><?php echo get_the_date(); ?></span>
                        <?php if ($is_paid) : ?>
                            <span class="video-price">$<?php echo number_format($video_price, 2); ?></span>
                        <?php else : ?>
                            <span class="video-price">Free</span>
                        <?php endif; ?>
                    </div>
                    <div class="video-description"><?php the_excerpt(); ?></div>
                    <a href="<?php the_permalink(); ?>" class="btn-primary video-link">Watch Video</a>
                </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>No videos found.</p>';
        endif;
        ?>
    </div> -->
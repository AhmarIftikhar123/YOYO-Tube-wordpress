<?php

use Inc\Helpers\Template_tags;
/**
 * Template part for carousels
 *
 * @package YoYo-Tube
 */

$args = [
    'posts_per_page' => 5,
    'post_type' => 'post', // Defaults to 'post', but shown for clarity and custom post type usage.
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
];

$post_query = new WP_Query($args);

$template_tags = new Template_tags();
?>

<div class="carousel">
    <?php if ($post_query->have_posts()): ?>
        <?php while ($post_query->have_posts()): $post_query->the_post(); ?>
            <div class="card">
                <?php if (has_post_thumbnail()): ?>
                    <?= $template_tags->get_the_post_custom_thumbnail(
                        get_the_ID(),
                        'featured-thumbnail',
                        [
                            'class' => 'card-img-top',
                            'sizes' => '(max-width: 590px) 350px, 230px',
                        ]
                    ); ?>
                <?php else: ?>
                    <img class="card-img-top" src="https://placehold.co/600x400?text=Post Can't Have Img" alt="Card image cap">
                <?php endif; ?>
                <div class="card-body">
                    <?php the_title('<h5 class="card-title">','</h5>') ?>
                    <p class="card-text">
                        <?= $template_tags->yoyo_the_excert(); ?>
                    </p>
                    <a href="<?= esc_url(get_permalink()) ?>" class="btn btn-primary">
                              <?php esc_html_e('Read More', 'yoyo-tube'); ?>
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>

</div>

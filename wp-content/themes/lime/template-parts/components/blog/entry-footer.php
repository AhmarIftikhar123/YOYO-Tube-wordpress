<?php
/**
 *  Entry Footer
 * To Be Used Inside Wordpress The Loop 
 * 
 * @package YOYO-Tube
 * 
 */
$post_id = get_the_ID();
$post_terms = wp_get_post_terms($post_id, ['category', 'post_tag']);
if (empty($post_terms || !is_array($post_terms))) {
          return;
}
?>

<div class="entery-footer">
          <?php
          foreach ($post_terms as $key => $article_term): ?>
                    <button class="btn btn-primary">
                              <a class="text-decoration-none text-white" href="<?= esc_url(get_term_link($article_term)) ?>">
                                        <?= $article_term->name ?></a>
                    </button>
          <?php endforeach; ?>
</div>
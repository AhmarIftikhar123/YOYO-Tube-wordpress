<?php
/**
 * Front page template
 *
 * @package YOYO-Tube
 */

use Inc\Helpers\Template_tags;

$template_tags = new Template_tags();

get_header();
?>

<main id="content" class="container">
          <div class="container">
                    <?php if (have_posts()): ?>
                              <div class="row">
                                        <div class="col-12">
                                                  <!-- If posts are found, display all posts content -->
                                                  <?php while (have_posts()):
                                                            the_post(); ?>
                                                            <?php get_template_part("template-parts/content", "page"); ?>
                                                  <?php endwhile; ?>
                                        </div>
                              </div>
                    <?php else: ?>
                              <!-- No posts found -->
                              <div class="row">
                                        <div class="col-12">
                                                  <?php get_template_part("template-parts/content-none"); ?>
                                        </div>
                              </div>
                    <?php endif; ?>
          </div>
          <?php // get_template_part("template-parts/components/carousel"); ?>
          <?php get_template_part("single"); ?>
</main>

<?php get_footer(); ?>
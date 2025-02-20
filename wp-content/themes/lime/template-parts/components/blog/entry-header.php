<?php
use Inc\Helpers\Template_tags;
/**
 * Entry Header Template
 * 
 * @package YOYO-Tube
 */

$template_tags = new Template_tags();
$current_post_id = get_the_ID();
$current_post_thumbnail = get_the_post_thumbnail($current_post_id);
// Get the heading status from the custom field
$get_current_heading = get_post_meta($current_post_id, '_hide_page_title', true);

// Check if the heading is hidden
$isheading_hidden = empty($get_current_heading) || $get_current_heading === 'yes' ? 'hidden' : '';
?>
<div class="container mt-5">
          <div class="row">
                    <!-- Main Content -->
                    <div class="column large-4 medium-6 small-12">
                              <!-- Blog Post -->
                              <div class="card mb-4">
                                        <div class="card-body">
                                                  <?= $template_tags->get_the_post_custom_thumbnail($current_post_id) ?>

                                                  <?php $page_title = wp_kses_post(get_the_title()); ?>
                                                  <?php if (is_single() || is_page()) {
                                                            $heading = sprintf(
                                                                      '<h1 class="page-title text-dark"
                                                                      %1$s
                                                                      >%2$s</h1>',
                                                                      esc_attr($isheading_hidden),
                                                                      $page_title
                                                            );
                                                  } else {
                                                            $heading = sprintf(
                                                                      '<h2 class"entry-title">%1$s</h2>',
                                                                      $page_title
                                                            );
                                                  }

                                                  echo $heading;
                                                  ?>

                                                  <p class="card-text">Lorem ipsum dolor sit amet, consectetur
                                                            adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum
                                                            ex quis soluta, a laboriosam.</p>
                                                  <?php if ($current_post_thumbnail): ?>
                                                            <a href="<?= esc_url(get_permalink()) ?>" class="btn btn-primary">Read
                                                                      More &rarr;</a>
                                                  <?php endif ?>
                                        </div>
                                        <div class="card-footer text-muted">
                                                  Posted on January 1, 2023 by
                                                  <a href="#">Admin</a>
                                        </div>
                              </div>
                    </div>
          </div>
</div>
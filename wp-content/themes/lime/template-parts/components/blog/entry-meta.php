<?php
/**
 * Entry Meta Template
 * 
 * @package YOYO-Tube
 */

use Inc\Helpers\Template_tags;

$template_tags = new Template_tags();
?>
<div class="card-footer text-muted mb-3">
          <div class="card-text">
                    <?= $template_tags->yoyo_the_excert() ?>
          </div>
          <!-- Get The Time And Date -->
          <?= $template_tags->yoyo_pusted_on() ?>
          <!-- Get The Author -->
          <?= $template_tags->yoyo_posted_by() ?>

</div>
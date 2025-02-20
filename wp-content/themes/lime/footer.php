<?php
/**
 * Footer template
 *
 * @package Lime
 */

?>
<footer class="site-footer" id="footer">
    <div class="container color-gray">
        <div class="row">
            <!-- <section class="col-lg-4 col-md-6 col-sm-12">
                Some Random Text
            </section> -->
            <section class="col-lg-4 col-md-6 col-sm-12">
                <?php if (function_exists('is_active_sidebar') && is_active_sidebar('footer')): ?>
                    <aside><?php dynamic_sidebar('footer'); ?></aside>
                <?php endif; ?>
            </section>
            <!-- <section class="col-lg-4 col-md-6 col-sm-12">
                <ul>
                    <li><a href="https://check">
                              <svg>
                                        <use  href='#checkbox'></use>
                              </svg>
                    </a></li>
                    <li><a href="https://cross">
                              <svg>
                                        <use  href='#cross'></use>
                              </svg>
                    </a></li>
                </ul>
            </section> -->
        </div>
    </div>
</footer>

<?php 
if (function_exists('wp_footer')) {
    wp_footer();
}

// get_template_part('template-parts/content', 'svgs'); 
?>

</body>
</html>

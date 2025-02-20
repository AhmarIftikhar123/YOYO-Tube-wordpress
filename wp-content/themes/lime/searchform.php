<?php
/**
 * Custom Searchform.
 */
?>
<!-- searchform.php -->
<form role="search" method="get" class="search-form form-inline" action="<?= esc_url(home_url('/')); ?>">
    <div class="input-group">
        <input type="search" class="form-control" placeholder="<?= esc_attr_x('Search...', 'placeholder', 'YOYO-Tube'); ?>" value="<?= get_search_query(); ?>" name="s" aria-label="Search">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>
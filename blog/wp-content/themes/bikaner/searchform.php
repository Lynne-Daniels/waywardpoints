
<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" >
    <fieldset>
        <label class="screen-reader-text" for="search"><?php esc_attr_e('Search for:', 'bikaner'); ?></label>
        <input type="text" name="s" id="search" class="search-query form-control input-small" value="<?php the_search_query(); ?>"  placeholder="<?php esc_attr_e('Search', 'bikaner'); ?>"/>
    </fieldset>
</form>
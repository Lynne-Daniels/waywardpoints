<?php
/*
 * @package Bikaner
 */
?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="secondary" class="widget-area col-xs-12 col-sm-4 col-md-4 col-lg-4 widget-sidebar-1" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>
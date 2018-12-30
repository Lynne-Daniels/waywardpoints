<?php
/**
 * @package Bikaner
 */


if ( ! is_active_sidebar( 'sidebar-2' ) && ! is_active_sidebar( 'sidebar-3' ) && ! is_active_sidebar( 'sidebar-4' )  && ! is_active_sidebar( 'sidebar-5' )  )
	return;

// If we get this far, we have widgets. Let do this.
?>
<div id="secondary" class="widget-area" role="complementary">
	<?php $count = 0;
		if ( is_active_sidebar( 'sidebar-2' ) ) $count += 1;
		if ( is_active_sidebar( 'sidebar-3' ) ) $count += 1;
		if ( is_active_sidebar( 'sidebar-4' ) ) $count += 1;
		if ( is_active_sidebar( 'sidebar-5' ) ) $count += 1;
		if ($count == 4) $span = 3;
		elseif ($count == 3) $span = 4;
		elseif ($count == 2) $span = 6;
		else $span = 12;

	?>
	<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
	<div class="first front-widgets col-lg-<?php echo $span?> col-md-<?php echo $span?> col-sm-<?php echo $span?> ">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</div><!-- .first -->
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
	<div class="second front-widgets col-lg-<?php echo $span?> col-md-<?php echo $span?> col-sm-<?php echo $span?>">
		<?php dynamic_sidebar( 'sidebar-3' ); ?>
	</div><!-- .second -->
	<?php endif; ?>
	
	<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
	<div class="third front-widget	s col-lg-<?php echo $span?> col-md-<?php echo $span?> col-sm-<?php echo $span?>">
		<?php dynamic_sidebar( 'sidebar-4' ); ?>
	</div><!-- .third -->
	<?php endif; ?>
	
	<?php if ( is_active_sidebar( 'sidebar-5' ) ) : ?>
	<div class="fourth front-widgets col-lg-<?php echo $span?> col-md-<?php echo $span?> col-sm-<?php echo $span?>">
		<?php dynamic_sidebar( 'sidebar-5' ); ?>
	</div><!-- .fourth -->
	<?php endif; ?>
</div><!-- #secondary -->
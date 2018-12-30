<?php
/**
 *
 * @package Bikaner
 */
?>
		</div><!--row---->
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo" class="footer-content">
	<div class=" container">
			<?php if ( is_active_sidebar( 'sidebar-2' ) || is_active_sidebar( 'sidebar-3' ) || is_active_sidebar( 'sidebar-4' ) || is_active_sidebar( 'sidebar-5' )  ): ?>
				<div id="secondary" class="widget-area footer-sidebar hidden-xs row" role="complementary">
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
			<?php endif; ?>
		<div class="row">
			<div class="site-info col-lg-12 col-sm-12 col-md-12 col-xs-12">
				<?php do_action( 'bikaner_credits' ); ?>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'bikaner' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'bikaner' ); ?>"><?php printf( __( 'Proudly powered by %s', 'bikaner' ), 'WordPress' ); ?></a> <a href="<?php echo esc_url( __( 'http://devcorn.com/', 'bikaner' ) ); ?>" rel="nofollow" title="<?php esc_attr_e( 'Bikaner WordPress Theme', 'bikaner' ); ?>"><?php printf( __( 'with %s theme', 'bikaner' ), 'Bikaner' ); ?></a> 
			</div><!-- .site-info --> 
		</div>
	</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
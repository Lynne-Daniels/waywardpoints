<?php
/**
 *
 * @package Bikaner
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
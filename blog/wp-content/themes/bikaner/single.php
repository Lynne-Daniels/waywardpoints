<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Bikaner
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main" class="col-xs-12 col-sm-8 col-md-8 col-lg-8" >

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

				<nav class="nav-single pager row">
					<h3 class="assistive-text"><?php _e( 'Post navigation', 'bikaner' ); ?></h3>
					<span class="text-left col-lg-6 col-md-6 col-sm-6 col-xs-6 col-no-pad"><?php previous_post_link( '%link', '<span class="meta-nav  glyphicon glyphicon-arrow-left"></span>' . _x( '', 'Previous post link', 'bikaner' ) . ' %title' ); ?></span>
					<span class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6 col-no-pad"><?php next_post_link( '%link', '%title <span class="meta-nav glyphicon glyphicon-arrow-right"></span>' . _x( '', 'Next post link', 'bikaner' ) ); ?></span>
				</nav><!-- .nav-single -->

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
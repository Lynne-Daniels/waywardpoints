<?php
/**
 * Template Name: Full-width Page Template, No Sidebar
 *
 * @package Bikaner
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; ?>

		</div>
	</div>

<?php get_footer(); ?>
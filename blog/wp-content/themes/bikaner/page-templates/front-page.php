<?php
/**
 * Template Name: Front Page Template
 *
 * @package Bikaner
 */

get_header(); ?>

	<div id="primary">
		<div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-page-image">
						<?php the_post_thumbnail(); ?>
					</div>
				<?php endif; ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile;  ?>

		</div>
	</div>

<?php get_footer(); ?>
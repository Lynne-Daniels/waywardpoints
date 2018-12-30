<?php
/**
 * @package Bikaner
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title alert alert-info"><?php
					if ( is_day() ) :
						printf( __( '<span  class="glyphicon glyphicon-calendar"></span> Daily Archives: %s', 'bikaner' ), '<span>' . get_the_date() . '</span>' );
					elseif ( is_month() ) :
						printf( __( '<span  class="glyphicon glyphicon-calendar"></span> Monthly Archives: %s', 'bikaner' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'bikaner' ) ) . '</span>' );
					elseif ( is_year() ) :
						printf( __( '<span  class="glyphicon glyphicon-calendar"></span> Yearly Archives: %s', 'bikaner' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'bikaner' ) ) . '</span>' );
					else :
						_e( 'Archives', 'bikaner' );
					endif;
				?></h1>
			</header><!-- .archive-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'content', get_post_format() );

			endwhile;

			bikaner_content_nav( 'nav-below' );
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php
/**
 * @package Bikaner
 */

get_header(); ?>

	<div id="primary">
		<?php if ( have_posts() ) :  ?>
			<?php if( is_home() && !is_paged() ): the_post();?>
				<div  id="content" role="main" class="first-post col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php get_template_part( 'content', get_post_format() ); ?>
				</div>
			<?php endif;?>
			<div  id="content" role="main" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
				<?php endwhile; ?>
				<?php bikaner_content_nav( 'nav-below' ); ?>
			</div>

		<?php else : ?>
			<div  id="content" role="main" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<article id="post-0" class="post no-results not-found">

				<?php if ( current_user_can( 'edit_posts' ) ) :
					// Show a different message to a logged-in user who can add posts.
				?>
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'No posts to display', 'bikaner' ); ?></h1>
					</header>

					<div class="entry-content">
						<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'bikaner' ), admin_url( 'post-new.php' ) ); ?></p>
					</div><!-- .entry-content -->

				<?php else :
					// Show the default message to everyone else.
				?>
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'bikaner' ); ?></h1>
					</header>

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'bikaner' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				<?php endif; // end current_user_can() check ?>

				</article><!-- #post-0 -->
			</div>

		<?php endif; // end have_posts() check ?>

	</div><!-- #primary -->
		
<?php get_sidebar(); ?>
<?php get_footer(); ?>

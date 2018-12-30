<?php
/**
 * @package Bikaner
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<article id="post-0" class="post error404 no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title "><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'bikaner' ); ?></h1>
				</header>

				<div class="entry-content">
					<p class="alert alert-warning"><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'bikaner' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
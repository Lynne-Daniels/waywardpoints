<?php

/**
 * @package Bikaner
 */
 
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header><?php _e( 'Link', 'bikaner' ); ?></header>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'bikaner' ) ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-meta">
			<span class=" glyphicon glyphicon-calendar"></span>
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'bikaner' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php echo get_the_date(); ?></a>
			
			<?php if ( comments_open() ) : ?>
			<div class="comments-link">
				<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'bikaner' ) . '</span>', __( '1 Reply', 'bikaner' ), __( '% Replies', 'bikaner' ) ); ?>
			</div>
			<?php endif;  ?>
			<?php edit_post_link( __( 'Edit', 'bikaner' ), '<span class="edit-link">', '</span>' ); ?>
		</footer>
	</article>

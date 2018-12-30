<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package Bikaner
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'bikaner' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single() ?>
			<div class="entry-header-meta">
				<?php bikaner_entry_meta(); ?>
				<?php if ( comments_open() ) : ?>
					<span class="leave-reply">
						<span class="glyphicon glyphicon-comment"></span>
						<?php comments_popup_link( __( 'Leave a reply', 'bikaner' ), __( '1 Reply', 'bikaner' ), __( '% Replies', 'bikaner' ) ); ?>
					</span>
				<?php endif; // comments_open() ?>
				<?php edit_post_link( __( 'Edit', 'bikaner' ), '<span class="edit-link"><span class="glyphicon glyphicon-pencil"></span> ', '</span>' ); ?>
			</div>
			<?php the_post_thumbnail('post-thumbnail',array('class'=> 'img-responsive')); ?>
		</header><!-- .entry-header -->
		
		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav glyphicon glyphicon-arrow-right"></span>', 'bikaner' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'bikaner' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

		<footer class="entry-meta">
			<?php if ( is_single() ) : 
				$tag_list = get_the_tag_list( '', __( ', ', 'bikaner' ) );
				if ( $tag_list ) {
					$tag_text = __( '<div class="tagged-in"><span class="tag-content"><span class="glyphicon glyphicon-tag"></span> %1$s</span></div>', 'bikaner' );
					printf($tag_text,$tag_list);
				}
				?>
				
			<?php endif; // is_single() ?>
			<?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
				<div class="author-info media alert alert-info">
					<div class="author-avatar pull-left">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'bikaner_author_bio_avatar_size', 68 ) ); ?>
					</div><!-- .author-avatar -->
					<div class="author-description  media-body">
						<h2 class="media-heading"><?php printf( __( 'About %s', 'bikaner' ), get_the_author() ); ?></h2>
						<p><?php the_author_meta( 'description' ); ?></p>
						<div class="author-link">
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php printf( __( 'View all posts by %s <span class="meta-nav glyphicon glyphicon-arrow-right"></span>', 'bikaner' ), get_the_author() ); ?>
							</a>
						</div><!-- .author-link	-->
					</div><!-- .author-description -->
				</div><!-- .author-info -->
			<?php endif; ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
<?php
/**
 * @package Bikaner
 */
 
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'bikaner' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<ol class="media-list">
			<?php wp_list_comments( array( 'callback' => 'bikaner_comment', 'style' => 'ol' ) ); ?>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation pager" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'bikaner' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '<span class=" glyphicon glyphicon-arrow-left"></span> Older Comments', 'bikaner' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="glyphicon glyphicon-arrow-right"></span>', 'bikaner' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments alert alert-info"><?php _e( 'Comments are closed.' , 'bikaner' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>
	<?php
	    $commenter = wp_get_current_commenter();
        $req = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
		
		$comments_args = array(
		  'comment_field' =>  '<div class="comment-form-comment form-group"><label for="comment" >' . __( 'Comment','bikaner') .
				'</label><div class="row"><div class="col-lg-9"><textarea id="comment" name="comment" class="form-control"  cols="45" rows="8" aria-required="true">' .
				'</textarea></div></div></div>',
		    'fields' => apply_filters( 'comment_form_default_fields', array(
				'author' =>
				  '<div class="comment-form-author form-group">' .
				  '<label for="author">' . __( 'Name', 'domainreference' ) .
				  ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
				  '<input id="author" name="author" type="text" class="form-control"  value="' . esc_attr( $commenter['comment_author'] ) .
				  '" size="30"' . $aria_req . ' /></div>',
				'email' =>
				  '<div class="comment-form-email form-group"><label for="email">' . __( 'Email', 'domainreference' ) .
				  ( $req ? '<span class="required">*</span>' : '' ) . '</label> '  .
				  '<input id="email" name="email" type="text"  class="form-control" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				  '" size="30"' . $aria_req . ' /></div>',

				'url' =>
				  '<div class="comment-form-url  form-group"><label for="url">' .
				  __( 'Website', 'domainreference' ) . '</label>' .
				  '<input id="url" name="url" type="text"  class="form-control" value="' . esc_attr( $commenter['comment_author_url'] ) .
				  '" size="30" /></div>'
				 )
			),
		
		);
		
	?>
	<?php  comment_form($comments_args);?>

</div><!-- #comments .comments-area -->
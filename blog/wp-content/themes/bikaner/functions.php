<?php
/**
 * @package Bikaner
 */

if ( ! isset( $content_width ) )
	$content_width = 770;
	
function bikaner_setup() {
	/*
	 * Makes Bikaner available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 */
	load_theme_textdomain( 'bikaner', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'bikaner' ) );

	/*
	 * This theme supports custom background color and image, and here
	 * we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'fff',
	) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
	
	// Bikaner about page
	add_action ( 'admin_menu', 'bikaner_add_about_page' );
	add_action ('admin_init','bikaner_theme_activation');
	add_action( 'admin_head', 'bikaner_admin_css' );
	add_filter('upgrader_post_install','bikaner_on_upgrade',1000);
    remove_filter('upgrader_post_install','bikaner_on_upgrade',1100);
    
}
add_action( 'after_setup_theme', 'bikaner_setup' );

/**
 * Adds support for a custom header image.
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Enqueues scripts and styles for front-end.
 *

 */
function bikaner_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Adds JavaScript for handling the navigation menu hide-and-show behavior.
	 */
	wp_enqueue_script( 'bikaner-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'bikaner-bootstrap-respond', get_template_directory_uri() . '/js/respond.min.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'bikaner-custom', get_template_directory_uri() . '/js/bikaner.js', array('jquery'), '1.0', true ); 


	/*
	 * Loads our special font CSS file.
	 *
	 * The use of Open Sans by default is localized. For languages that use
	 * characters not supported by the font, the font can be disabled.
	 *
	 * To disable in a child theme, use wp_dequeue_style()
	 * function mytheme_dequeue_fonts() {
	 *     wp_dequeue_style( 'bikaner-fonts' );
	 * }
	 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
	 */

	/* translators: If there are characters in your language that are not supported
	   by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'bikaner' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language, translate
		   this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'bikaner' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400italic,700italic,400,700',
			'subset' => $subsets,
		);
		wp_enqueue_style( 'bikaner-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}

	/*
	 * Loads bootstrap stylesheet.
	 */
	wp_enqueue_style( 'bikaner-bootstrap-style', get_template_directory_uri() .'/css/bootstrap.min.css' );
	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'bikaner-style', get_stylesheet_uri() );


}
add_action( 'wp_enqueue_scripts', 'bikaner_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
  */
  
 /**
  * Bikaner about page
  */
function bikaner_theme_activation()
{
    global $pagenow;
	global $wp_version;
	
	if (version_compare( $wp_version, '3.4' , '>=' ) ) {
	    if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) 
	    {
            header( 'Location: '.admin_url().'themes.php?page=about-bikaner.php' ) ;
        }
	}
    else 
	{
	      add_action('admin_notices', 'bikaner_upgrade_notice');
    }
 
}
function bikaner_upgrade_notice()
{
?>
  <div class="error">
  <p>
  <?php _e('Thanks for using Bikaner theme, it requires WordPress 3.4+.','bikaner') ?>
  <a href="<?php echo admin_url().'update-core.php' ?>" title="<?php _e( 'Upgrade WordPress Now' , 'bikaner' ) ?>">
  <?php _e( 'Upgrade Wordpress Now' , 'bikaner' ) ?></a>
  </p>
  </div>
  <div class="updated"><p>
  <a href="<?php echo admin_url().'themes.php?page=about-bikaner.php'  ?>" title="<?php _e( 'About Bikaner' , 'bikaner' ) ?>">
  <?php _e( 'About Bikaner WordPress theme' , 'bikaner' ) ?></a></p>
  </div>

<?php 
}

function bikaner_add_about_page() {
        $theme_page = add_theme_page(
            __( 'About Bikaner' , 'bikaner' ),   
            __( 'About Bikaner' , 'bikaner' ),   
            'edit_theme_options' ,          
            'about-bikaner.php' ,           
            'bikaner_about_page'         
        );
    }
	
function bikaner_admin_css()
{
?>
     <style>
     #bkn-menu-wrap {
       margin: 25px 0;
     }
     .bkn-iblock {
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
	display: block;
	margin: 10px 0;
	padding: 10px;
	text-align: left;
	}
    .bkn-icontent {
	background-color: #ECECEC;
	border: 1px solid #e2e2e2;
	color: #333;
    }
	.bkn-social {
	display:inline-block;
		}
	
     </style>

	 <?php
}

function bikaner_on_upgrade() {
      
      if ( !isset($_GET['action']) ) {
        return false;
      }
      
      if ( !isset($_GET['theme']) ) {
        return false;
      }

      //is_customizr_upgrade ?
      if ( $_GET['action'] == 'upgrade-theme' && $_GET['theme'] == 'bikaner') {
        show_message( '<span class="hide-if-no-js">' . sprintf( __( 'Thank you for upgrading to the new version of Bikaner. You will be redirected to the About screen. If not, click <a href="%1$s">here</a>.' , 'bikaner'), esc_url( self_admin_url( 'themes.php?page=about-bikaner.php&action=bikaner-update' ) ) ) . '</span>' );
        ?>
          <script type="text/javascript">
          window.location = '<?php echo self_admin_url( 'themes.php?page=about-bikaner.php&action=bikaner-update' ); ?>';
          </script>
        <?php
      }

    }

function bikaner_about_page() {

	  global $wp_version;
      $is_upgrade = false;
	  $bikaner_info = wp_get_theme();
	  
      if ( isset($_GET['action']) ) {
        if ( $_GET['action'] == 'bikaner-update' ) {
          $is_upgrade = true;
        }
      }
    ?>
      <div class="wrap about-wrap">
        <h1><?php printf( __( 'Welcome to Bikaner %s','bikaner' ), $bikaner_info->Version ); ?></h1>
          <?php  if ($is_upgrade) : ?>
          <div class="about-text">
            <?php printf( __( 'Thank you for upgrading to the Bikaner %1$s. The Responsive Mobile friendly WordPress theme. Bikaner is built with mobile-first front-end framework Twitter Bootstrap. <br/> Click on Tutorials below to know how to set-up and how it works. ','bikaner' ), 
            $bikaner_info->Version   
            ); ?>
            </div>
         <?php else: ?>
         <div class="about-text">
            <?php  _e( 'Thanks for choosing Bikaner WordPress theme. The Responsive Mobile friendly WordPress theme. Bikaner is built with mobile-first front-end framework Twitter Bootstrap. <br/> Click on Tutorials below to know how to set-up and how it works.','bikaner' ) ?>
		  </div>
		 <?php endif; ?>
	 <div class="bkn-social">
	  <a href="https://twitter.com/thedevcorn" class="twitter-follow-button" data-show-count="false">Follow @thedevcorn</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<div class="g-follow" data-annotation="bubble" data-height="20"   data-href="//plus.google.com/100269342534981184484" data-rel="publisher"></div>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<iframe src="//www.facebook.com/plugins/follow.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FThedevcorn%2F613764581991415&amp;width=150&amp;height=20&amp;colorscheme=light&amp;layout=button_count&amp;show_faces=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:150px; height:20px;" allowTransparency="true"></iframe>

</div>

	    <div id="bkn-menu-wrap">
		<div class="bkn-iblock bkn-icontent">
         <a class="button-primary" href="http://devcorn.com/wordpress/themes/bikaner"><?php _e('Tutorials','bikaner')?></a>
		 <a class="button" href="http://devcorn.com/wordpress/themes/"><?php _e('Other Themes','bikaner')?></a>
		 <a class="button" href="http://wordpress.org/support/theme/bikaner"><?php _e('Support','bikaner')?></a>
		 <a class="button" href="http://devcorn.com/contact-us/"><?php _e('Contact us','bikaner')?></a>
        </div></div>
	<div class="changelog">	
		<div class="feature-section col two-col">
		<div>
			<h4><?php _e( 'Contribute to keep this free theme alive','bikaner' ); ?></h4>
			<p><?php _e( 'We do our best to make good themes and distribute it for free. We are still not full-time on WordPress, help us to move 100% on WordPress.','bikaner' ); ?><br/><small><strong><?php _e( 'Payments are powered by PayPal, you will be able to update any amount on PayPal site','bikaner' ); ?></small></strong></p>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="87EJ2TAPVN6NC">
<input type="image" src="<?php echo get_template_directory_uri(); ?>/img/admin/gcontribute1.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>
		</div>
		<div class="last-feature">
			<h4><?php _e( 'Write review and give ratings on WordPress','bikaner' ); ?></h4>
			<p><?php _e( 'If you liked Bikaner, then please give rating and reviews on WordPress site to help others. It will help others to know before downloading what they can expect from this theme.','bikaner' ); ?></p><a href="http://wordpress.org/support/view/theme-reviews/bikaner"><img src="<?php echo get_template_directory_uri(); ?>/img/admin/takemeonwp.png" border="0" style="display: block;margin-top: 20px;border:none;shadow:none;-webkit-box-shadow:none" alt="Take me on WordPress" /></a>
			</div>
	</div>

	<h3><?php _e( 'Bikaner Features at a glance','bikaner' ); ?></h3>

	<div class="feature-section images-stagger-right">
		<img alt="" src="<?php echo get_template_directory_uri(); ?>/img/admin/bikaner-screenshot.png" class="image-66" />
		<h4><?php printf( __( 'Version %s','bikaner' ), $bikaner_info->Version ); ?></h4>
		<p><?php _e( "<br/>* Aligned with Twitter Bootstrap versioning <br/> * Built on Twitter Bootstrap 3 <br/> * Clean Minimilist design <br/>* Embeeded Glyphicons - for meta data <br/> * Full Width and Frontpage Template <br/> * Custom Header Image <br/> * Featured Image <br/> * Featured sticky post <br/> * Four Footer widgets <br/> * Embedded Search box in nav bar  ",'bikaner') ?></p>
		
		
	</div>
</div>   
<div class="changelog">
	<h3><?php _e( 'Responsive Design','bikaner' ); ?></h3>

	<div class="feature-section images-stagger-right">
		<img alt="" src="<?php echo get_template_directory_uri(); ?>/img/admin/bikaner-responsive.png" class="image-66" />
		<h4><?php _e( 'Theme adapts the device size','bikaner' ); ?></h4>
		<p></p>
		<p><?php _e( 'Bikaner WordPress theme is built on Twitter Bootstrap 3, which is mobile first front-end responsive framework.','bikaner' ); ?></p>
		<p><?php _e( 'Theme adapts the design as per the readers device size ( PC, Mobile, Tablet), It provides consistent reading experience across devices.','bikaner' ); ?></p>
		<h4><?php _e( 'Best is yet to come, Support it by contributing. ','bikaner' ); ?></h4>
		<p><?php _e('Any kind of contribution is appreciated.','bikaner' ); ?> </p>
	</div>      
      <div class="return-to-dashboard">
	    <a href="<?php echo esc_url( self_admin_url() ); ?>"><?php
          is_blog_admin() ? _e( 'Go to Dashboard &rarr; Home','bikaner' ) : _e( 'Go to Dashboard','bikaner' ); ?></a>
      </div>

    </div>
    <?php
    }

/* End Bikaner About */

function bikaner_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'bikaner' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'bikaner_wp_title', 10, 2 );

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *

 */
function bikaner_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'bikaner_page_menu_args' );

/**
 * Registers our main widget area and the front page widget areas.
 *

 */
function bikaner_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'bikaner' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'bikaner' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'bikaner' ),
		'id' => 'sidebar-2',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'bikaner' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Second Footer Page Widget Area', 'bikaner' ),
		'id' => 'sidebar-3',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'bikaner' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Third Footer Page Widget Area', 'bikaner' ),
		'id' => 'sidebar-4',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'bikaner' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Fourth Footer Page Widget Area', 'bikaner' ),
		'id' => 'sidebar-5',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'bikaner' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'bikaner_widgets_init' );

if ( ! function_exists( 'bikaner_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 */
function bikaner_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation pager" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'bikaner' ); ?></h3>
			<div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav glyphicon glyphicon-arrow-left"></span> Older posts', 'bikaner' ) ); ?></div>
			<div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav glyphicon glyphicon-arrow-right"></span>', 'bikaner' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;

if ( ! function_exists( 'bikaner_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own bikaner_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
function bikaner_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'bikaner' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'bikaner' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class('media'); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="media">
			<a class="pull-left" href="#">
				<?php echo get_avatar( $comment, 40 );?>
			</a>
			<div class="media-body">
				<h4 class="media-heading">
					<header class="media-heading">
						
							
								<?php
									printf( '<cite class="fn">%1$s %2$s</cite>',
										get_comment_author_link(),
										// If current post author is also comment author, make it known visually.
										( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'bikaner' ) . '</span>' : ''
									);
									printf( '<div><small><a href="%1$s"><time datetime="%2$s">%3$s</time></a></small></div>',
										esc_url( get_comment_link( $comment->comment_ID ) ),
										get_comment_time( 'c' ),
										/* translators: 1: date, 2: time */
										sprintf( __( '%1$s at %2$s', 'bikaner' ), get_comment_date(), get_comment_time() )
									);
								?>
						
					</header><!-- .comment-meta -->
				</h4>
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'bikaner' ); ?></p>
				<?php endif; ?>

				<section class="comment-content comment">
					<?php comment_text(); ?>
				</section><!-- .comment-content -->








				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'bikaner' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
				<?php edit_comment_link( __( 'Edit', 'bikaner' ), '<div class="edit-link">', '</div>' ); ?>
			</div>
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'bikaner_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own bikaner_entry_meta() to override in a child theme.
 *

 */
function bikaner_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'bikaner' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'bikaner' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is author's name, 2 is date, 3 is the category.
	if ( $categories_list ) {
		$utility_text = __( '<span class="by-author"><span class="glyphicon glyphicon-user"></span> %1$s</span><span class="date-link"><span class="glyphicon glyphicon-time"></span> %2$s</span><span class="category-link"><span class="glyphicon glyphicon-list-alt"></span> %3$s</span>', 'bikaner' );
	} else {
		$utility_text = __( '<span class="by-author"><span class="glyphicon glyphicon-user"></span> %1$s</span><span class="date-link"><span class="glyphicon glyphicon-time"></span> %2$s</span>', 'bikaner' );
	}

	printf(
		$utility_text,
		$author,
		$date,
		$categories_list
	);
}
endif;

/**
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.

 *
 * @param array Existing class values.
 * @return array Filtered class values.
 */
function bikaner_body_class( $classes ) {
	$background_color = get_background_color();

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) )
		$classes[] = 'full-width';

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() )
			$classes[] = 'has-post-thumbnail';

	}

	if ( empty( $background_color ) )
		$classes[] = 'custom-background-empty';
	elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
		$classes[] = 'custom-background-white';

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'bikaner-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'bikaner_body_class' );

/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 */
function bikaner_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 1160;
	}
}
add_action( 'template_redirect', 'bikaner_content_width' );
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function bikaner_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'bikaner_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 */
function bikaner_customize_preview_js() {
	wp_enqueue_script( 'bikaner-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20120827', true );
}
add_action( 'customize_preview_init', 'bikaner_customize_preview_js' );

class bikaner_walker_nav_menu extends Walker_Nav_Menu {
	
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"dropdown-menu\">\n";
	}
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		if ($args->has_children && $depth > 0) {
			$classes[] = 'dropdown-submenu';
		} else if($args->has_children && $depth === 0) {
			$classes[] = 'dropdown';
		}
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ($args->has_children) 	    ? ' data-toggle="dropdown" data-target="#" class="dropdown-toggle"' : '';
			
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= ($args->has_children && $depth == 0) ? '<span class="caret"></span></a>' : '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		//display this element
		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) ) 
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] ); 
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array($this, 'start_el'), $cb_args);

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

			foreach( $children_elements[ $id ] as $child ){

				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array($this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[ $id ] );
		}

		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array($this, 'end_lvl'), $cb_args);
		}

		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array($this, 'end_el'), $cb_args);
	}
}

function bikaner_wp_page_menu( $args = array() ) {

	$defaults = array('sort_column' => 'menu_order, post_title', 'menu_class' => 'menu', 'echo' => true, 'link_before' => '', 'link_after' => '');
	$args = wp_parse_args( $args, $defaults );
	$args = apply_filters( 'wp_page_menu_args', $args );

	$menu = '';

	$list_args = $args;

	// Show Home in the menu
	if ( ! empty($args['show_home']) ) {
		if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )
			$text = __('Home','bikaner');
		else
			$text = $args['show_home'];
		$class = '';
		if ( is_front_page() && !is_paged() )
			$class = 'class="current_page_item"';
		$menu .= '<li ' . $class . '><a href="' . home_url( '/' ) . '" title="' . esc_attr($text) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';
		// If the front page is a page, add it to the exclude list
		if (get_option('show_on_front') == 'page') {
			if ( !empty( $list_args['exclude'] ) ) {
				$list_args['exclude'] .= ',';
			} else {
				$list_args['exclude'] = '';
			}
			$list_args['exclude'] .= get_option('page_on_front');
		}
	}

	$list_args['echo'] = false;
	$list_args['title_li'] = '';
	$list_args['walker'] = new bikaner_walker_page_menu;
	$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages($list_args) );

	if ( $menu )
		$menu = '<ul class="'. esc_attr($args['menu_class']) .'">' . $menu . '</ul>';

	$menu = '<div class="' . esc_attr($args['container_class']) . '">' . $menu . "</div>\n";
	$menu = apply_filters( 'wp_page_menu', $menu, $args );
	if ( $args['echo'] )
		echo $menu;
	else
		return $menu;
}
class bikaner_walker_page_menu extends Walker_Page{
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class='dropdown-menu'>\n";
	}
	function start_el( &$output, $page, $depth=0, $args = array(), $current_page = 0 ) {
		if ( $depth )
			$indent = str_repeat("\t", $depth);
		else
			$indent = '';

		extract($args, EXTR_SKIP);
		$css_class = array('page_item', 'page-item-'.$page->ID);
		if ( !empty($current_page) ) {
			$_current_page = get_post( $current_page );
			if ( in_array( $page->ID, $_current_page->ancestors ) )
				$css_class[] = 'current_page_ancestor';
			if ( $page->ID == $current_page )
				$css_class[] = 'current_page_item';
			elseif ( $_current_page && $page->ID == $_current_page->post_parent )
				$css_class[] = 'current_page_parent';
		} elseif ( $page->ID == get_option('page_for_posts') ) {
			$css_class[] = 'current_page_parent';
		}

		$css_class = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

		$output .= $indent . '<li class="' . $css_class . '"><a href="' . get_permalink($page->ID) . '">' . $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a>';

		if ( !empty($show_date) ) {
			if ( 'modified' == $show_date )
				$time = $page->post_modified;
			else
				$time = $page->post_date;

			$output .= " " . mysql2date($date_format, $time);
		}
	}


}
function bikaner_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post"> <div class="form-group">
    ' . __( "<p class='help-block'>To view this protected post, enter the password below:</p>" ) . '
    <label for="' . $label . '">' . __( "Password:",'bikaner' ) . ' </label><div class="row"><div class="col-lg-5"><input name="post_password" class="form-control input-small" id="' . $label . '" type="password" size="20" maxlength="20" /></div></div></div><input type="submit" class="pwd-submit" name="Submit" value="' . esc_attr__( "Submit" ) . '" />
    </form>
    ';
    return $o;
}
add_filter( 'the_password_form', 'bikaner_password_form' );
<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Bikaner
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">


	<header id="masthead" class="site-header text-center " role="banner">
	
		<nav id="site-navigation" class="main-navigation navbar navbar-default" role="navigation">
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'bikaner' ); ?>"><?php _e( 'Skip to content', 'bikaner' ); ?></a>
				<div class="container"  >
						<div class="navbar-header alignleft">									

							<!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
							<button type="button" class="navbar-toggle alignleft" data-toggle="collapse" data-target=".primary-menu-collapse"  >
							  <span class="icon-bar"></span>
							  <span class="icon-bar"></span>
							  <span class="icon-bar"></span>
							</button>

							<a class="navbar-brand" href="#"></a>
						</div>
						<div class="navbar-form" >
							<?php get_search_form( ); ?>
						</div>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'navbar-nav nav ' , 'container_class' => 'collapse navbar-collapse primary-menu-collapse','walker' => new bikaner_walker_nav_menu(),'fallback_cb'=>'bikaner_wp_page_menu' )); ?>
								
				</div>
						
		</nav><!-- #site-navigation -->

		<hgroup class="container site-title">
		<div class="row">
		<div class="col-xs-12 col-lg-12 col-md-12 col-sm-12">
			<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</h1>
		</div>
		</div>
		</hgroup>
		
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<div class="container">
				<div class="row header-img">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image img-responsive" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
				</div>
			</div>
		<?php endif; ?>
		
	</header><!-- #masthead -->

	<div id="main" class="container">
		<div class="row">
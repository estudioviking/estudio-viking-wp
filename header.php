<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package Estudio_Viking_WP
 * @since 1.0.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif; ?>

		<!--[if lt IE 9]>
			<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js"></script>
		<![endif]-->

		<?php wp_head(); ?>
	</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a id="skip-link" class="sr-only sr-only-focusable" href="#content" title="<?php esc_attr_e( 'Skip to content', 'evwp' ); ?>">
		<div class="container">
			<span class="skip-link-text"><?php _e( 'Skip to content', 'evwp' ); ?></span>
		</div>
	</a>

	<nav id="nav-header" class="navbar navbar-default navbar-fixed-top">
		<header id="header" class="container" role="banner">
			<hgroup id="brand" class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-menu-nav" aria-controls="navbar">
					<span class="sr-only"><?php _e( 'Click on the button to display the menu.', 'evwp' ); ?></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				
				<div id="header-txt">
					<?php if ( is_home() || is_front_page() ) : ?>
						<h1 id="name"><a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php _e( 'Go to home page?', 'evwp' ); ?>" rel="home"><span><?php bloginfo( 'name' ); ?></span></a></h1>
						<h2 id="desc" class="sr-only sr-only-focusable"><?php bloginfo( 'description' ); ?></h2>
					<?php else : ?>
						<p id="name" class="h1"><a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></p>
						<p id="desc" class="h2 sr-only sr-only-focusable"><?php bloginfo( 'description' ); ?></p>
					<?php endif; ?>
				</div><!-- #head-txt -->
			</hgroup><!-- #brand -->
			
			<div id="header-menu-nav" class="collapse navbar-collapse">
				<?php
					wp_nav_menu( array(
						'theme_location'	=> 'primary',
						'container'			=> false,
						'menu_id'			=> 'header-menu',
						'menu_class'		=> 'nav navbar-nav',
						'depth'				=> 2,
						'fallback_cb'		=> 'ID_WP_Bootstrap_Nav_Walker::fallback',
						'walker'			=> new ID_WP_Bootstrap_Nav_Walker()
					) );
					echo '<!-- #header-menu -->';
				?>
				<form id="navbar-search-form" class="navbar-form navbar-right" method="get" action="<?php echo home_url( '/' ); ?>" role="search">
					<div class="form-group">
						<label for="s" class="control-label sr-only"><?php _e( 'Search', 'evwp' ); ?></label>
						<div class="input-group">
							<input class="form-control" type="search" name="s" placeholder="<?php _e( 'Search', 'evwp' ); ?>">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit" role="button">
									<span class="sr-only"><?php _e( 'Search', 'evwp' ); ?></span> <span class="glyphicon glyphicon-search"></span>
								</button>
							</span>
						</div>
					</div>
				</form><!-- #navbar-search-form -->
			</div><!-- #header-menu-nav -->
		</header><!-- #header -->
	</nav><!-- #nav-header -->

	<div id="content" class="site-content">
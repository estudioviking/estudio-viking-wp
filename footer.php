<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Estudio_Viking_WP
 */

?>

	</div><!-- #content -->

	<section id="bottom-sidebar">
		<div class="container">

			<div id="sidebar" class="row">
				<div id="sidebar-1" class="col-sm-4 col-md-4 widget-area">
					<?php
						$defaults = array(
							'before_widget'	=> '<section class="widget sidebar-module %s">',
							'before_title'	=> '<h3 class="widget-title">',
							'after_title'	=> '</h3>',
							'after_widget'	=> '</section>'
						);

						if ( is_active_sidebar( 'sidebar-1' ) ) :
							dynamic_sidebar( 'sidebar-1' );
						else :
							the_widget( 'WP_Widget_Recent_Posts', array(), $defaults );
						endif;
					?>
				</div><!-- #sidebar-1 -->
				<div id="sidebar-2" class="col-sm-4 col-md-4 widget-area">
					<?php
						if ( is_active_sidebar( 'sidebar-2' ) ) :
							dynamic_sidebar( 'sidebar-2' );
						else :
							the_widget( 'WP_Widget_Pages', array(), $defaults );
						endif;
					?>
				</div><!-- #sidebar-2 -->
				<div id="sidebar-3" class="col-sm-4 col-md-4 widget-area">
					<?php
						if ( is_active_sidebar( 'sidebar-3' ) ) :
							dynamic_sidebar( 'sidebar-3' );
						else :
							the_widget( 'WP_Widget_Meta', array(), $defaults );
						endif;
					?>
				</div><!-- #sidebar-3 -->
			</div><!-- #sidebar -->
			
		</div>
	</section><!-- #bottom-sidebar -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">

			<p id="copyright" class="site-info pull-left">
				<?php
					printf( '%1$s | %2$s %3$s %4$s %5$s.',
						'<span class="site-title"><a href="' .
						esc_url( home_url( '/' ) ) . '" rel="home">' .
						bloginfo( 'name', 'display' ) . '</a></span>',
						__( 'Powered by', ID_THEME_NAME ),
						sprintf( '<a href="%s" rel="nofollow" target="_blank">%s</a>',
							'https://github.com/id-design/',
							'ID Design' ),
						__( 'on', ID_THEME_NAME ),
						sprintf( '<a href="%s" rel="nofollow" target="_blank">%s</a>',
							'http://wordpress.org/',
							'WordPress' )
					);
				?>
			</p><!-- #copyright -->

			<nav id="nav-footer" class="pull-right">
				<?php
					wp_nav_menu( array(
						'theme_location'	=> 'social',
						'container'			=> false,
						'menu_id'			=> 'social-menu',
						'menu_class'		=> 'nav nav-pills',
						'depth'				=> 2,
						'fallback_cb'		=> 'ID_WP_Bootstrap_Nav_Walker::fallback',
						'walker'			=> new ID_WP_Bootstrap_Nav_Walker()
					) );
					echo '<!-- #header-menu -->';
				?>
			</nav><!-- #nav-footer -->

		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

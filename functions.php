<?php
/**
 * Estúdio Viking WP functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Estudio_Viking_WP
 * @since 1.0.0
 */


/**
 * Default theme constants
 * ----------------------------------------------------------------------------
 */
define( 'ID_THEME_NAME', 'evwp' );


/**
 * Require ID Core Classes
 * 
 * @since 1.0.0
 * ----------------------------------------------------------------------------
 */
require_once get_template_directory() . '/core/classes/class-bootstrap-nav.php';


if ( ! function_exists( 'evwp_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own evwp_setup() function to override in a child theme.
 *
 * @since 1.0.0
 */
function evwp_setup() {
	/**
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Estúdio Viking WP, change 'evwp'
	 * in 'ID_THEME_NAME' constant value to the name of your theme.
	 */
    load_theme_textdomain( ID_THEME_NAME, get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 * 
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	//set_post_thumbnail_size( 1200, 9999 );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', ID_THEME_NAME ),
		'social'  => __( 'Social Links Menu', ID_THEME_NAME ),
	) );

	/**
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/**
	 * Enable support for Post Formats.
	 * 
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );

	/**
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'assets/css/editor-style.css' ) );
}
endif; // evwp_setup
add_action( 'after_setup_theme', 'evwp_setup' );


/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since 1.0.0
 */
function evwp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'evwp_content_width', 877.5 );
}
add_action( 'after_setup_theme', 'evwp_content_width', 0 );


/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since 1.0.0
 */
function evwp_widgets_init() {
	// Define default args.
	$defaults = array(
		'before_widget'	=> '<section id="%1$s" class="widget sidebar-module %2$s">',
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
		'after_widget'	=> '</section>'
	);
/*
	// Define Sidebar.
	register_sidebar( wp_parse_args( array(
		'name'          => __( 'Sidebar', ID_THEME_NAME ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', ID_THEME_NAME )
	), $defaults ) );
*/
	// Define Content Bottom 1.
	register_sidebar( wp_parse_args( array(
		'name'          => __( 'Content Bottom 1', ID_THEME_NAME ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', ID_THEME_NAME )
	), $defaults ) );

	// Define Content Bottom 2.
	register_sidebar( wp_parse_args( array(
		'name'          => __( 'Content Bottom 2', ID_THEME_NAME ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', ID_THEME_NAME )
	), $defaults ) );

	// Define Content Bottom 3.
	register_sidebar( wp_parse_args( array(
		'name'          => __( 'Content Bottom 3', ID_THEME_NAME ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', ID_THEME_NAME )
	), $defaults ) );
}
add_action( 'widgets_init', 'evwp_widgets_init' );


/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function evwp_scripts() {
	$theme_url = get_template_directory_uri();

	// Load Estudio Viking WP main stylesheet.
	wp_enqueue_style( 'evwp-style', get_stylesheet_uri(), array(), null, 'all' );

	// JQuery.
	wp_enqueue_script( 'jquery' );

	// General scripts.
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		// Bootstrap.
		wp_enqueue_script( 'bootstrap', $theme_url . '/assets/js/libs/bootstrap.min.js', array(), null, true );
		// Main jQuery.
		wp_enqueue_script( 'evwp-main', $theme_url . '/assets/js/main.js', array(), null, true );
	} else {
		// Grunt main file with Bootstrap and others libs.
		wp_enqueue_script( 'evwp-main-min', $theme_url . '/assets/js/main.min.js', array(), null, true );
	}

	// Load Skip Link normalizer.
	wp_enqueue_script( 'evwp-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20150310', true );

	// Load thread comments WordPress script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'evwp_scripts' );


/**
 * Estúdio Viking WP custom stylesheet URI.
 *
 * @since  1.0.0
 *
 * @param  string $uri Default URI.
 * @param  string $dir Stylesheet directory URI.
 *
 * @return string      New URI.
 */
function evwp_stylesheet_uri( $uri, $dir ) {
	return $dir . '/assets/css/style.css';
}
add_filter( 'stylesheet_uri', 'evwp_stylesheet_uri', 10, 2 );

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
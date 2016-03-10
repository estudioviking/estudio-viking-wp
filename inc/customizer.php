<?php
/**
 * Estudio Viking WP Customizer functionality
 *
 * @package Estudio Viking WP
 * @since 1.0.0
 */


/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since 1.0.0
 *
 * @see evwp_header_style()
 */
function evwp_custom_header_and_background() {
	/**
	 * Filter the arguments used when adding 'custom-background' support in Twenty Sixteen.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 *     @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'evwp_custom_background_args', array(
		'default-color'			=> 'fff',
		'default-attachment'	=> 'scroll'
	) ) );

	/**
	 * Filter the arguments used when adding 'custom-header' support in Twenty Sixteen.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 * 
	 *     @type	string		$default-text-color	Default color of the header text.
	 *     @type	int			$width				Width in pixels of the custom header image. Default 1170.
	 *     @type	int 		$height				Height in pixels of the custom header image. Default 50.
	 *     @type	bool		$flex-height		Whether to allow flexible-height header images. Default true.
	 *     @type	callable	$wp-head-callback	Callback function used to style the header image and text
	 *     											displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'evwp_custom_header_args', array(
		'default-text-color'     => '',
		'width'                  => 1170,
		'height'                 => 50,
		'flex-height'            => true,
		'wp-head-callback'       => 'evwp_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'evwp_custom_header_and_background' );


if ( ! function_exists( 'evwp_header_style' ) ) :
/**
 * Styles the header text displayed on the site.
 *
 * Create your own evwp_header_style() function to override in a child theme.
 *
 * @since 1.0.0
 *
 * @see evwp_custom_header_and_background().
 */
function evwp_header_style() {
	$header_image = get_header_image();
	$text_color   = get_header_textcolor();
	
	// If no custom options for text are set, let's bail.
	if ( ! $text_color && empty( $header_image ) ) return;
	
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css" id="evwp-header-css">
	<?php
		// Has a Custom Header been added?
		if ( ! empty( $header_image ) ) :
	?>
		#nav-header {
			background: url(<?php header_image(); ?>) no-repeat scroll top center;
			background-size: 100% auto;
		}
	<?php endif;
		
		// Has the text been visible?
		if ( display_header_text() ) :
	?>
		#name a { color: #<?php echo esc_attr( $text_color ); ?>; }
	<?php endif;
		
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		#header-txt span {
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // evwp_header_style

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 * 
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function evwp_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport			= 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport	= 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport	= 'postMessage';
}
add_action( 'customize_register', 'evwp_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 * 
 * @since 1.0.0
 */
function evwp_customize_preview_js() {
	wp_enqueue_script( 'estudio_viking_wp_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20160310', true );
}
add_action( 'customize_preview_init', 'evwp_customize_preview_js' );
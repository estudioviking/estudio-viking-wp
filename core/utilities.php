<?php
/**
 * Functions for some basic utilities in the theme
 *
 * @package ID WordPress
 * @category Utilities
 * @version 1.0.0
 */


/**
 * Convert hexadecimal colors to RGB
 * 
 * @since 1.0.0
 * 
 * @param	string	$hex		Hexadecimal color code
 * @param	bool	$implode	If 'true', return string separed by commas. If 'false', return array( $r, $g, $b ).
 * 								Default: 'true'
 * @return	string/array		Hexadecimal color code converted to RGB
 * ============================================================================
 */
function hex2rgb( $hex, $implode = true ) {
	$hex = str_replace( '#', '', $hex );
	
	if ( strlen( $hex ) == 3 ) {
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
		$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
		$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	} else {
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	}
	
	$rgb = array( $r, $g, $b );
	
	// Return string separated by commas
	if ( true === $implode ) $rgb = implode( ',', $rgb );
	
	return $rgb;
}


/**
 * Convert RGB colors to hexadecimal
 * 
 * @since 1.0.0
 * 
 * @param	string/array	$rgb	RGB color code
 * @param	bool			$dash	If 'true', start output string with '#'. Default: 'true'
 * @return	string					RGB color code converted to hexadecimal
 * ============================================================================
 */
function rgb2hex( $rgb, $dash = true ) {
	$rgb = ( is_array( $rgb ) ) ? $rgb : explode( ',', trim( $rgb ) );
	
	$hex = '';
	$hex .= ( true === $dash ) ? '#' : '';	// Start output string with '#'.
	$hex .= str_pad( dechex( $rgb[0] ), 2, '0', STR_PAD_LEFT );
	$hex .= str_pad( dechex( $rgb[1] ), 2, '0', STR_PAD_LEFT );
	$hex .= str_pad( dechex( $rgb[2] ), 2, '0', STR_PAD_LEFT );
	
	return $hex;
}


/**
 * Convert hexadecimal/alpha colors to rgba
 * 
 * @since 1.0.0
 * 
 * @param	array	$hexalpha	Array where $hexalpha['color'] is the hexadecimal color and
 * 								$hexalpha['alpha'] is the opacity code
 * @return	string				Hexadecial/alpha color array converted to rgba color code
 * ============================================================================
 */
function hexalpha2rgba( $hexalpha ) {
	$hex = $hexalpha['color'];
	$rgb = hex2rgb( $hex );
	$alpha = $hexalpha['alpha'];
	$rgba = $rgb . ',' . $alpha;
	
	return $rgba;	// Return string separated by commas
}

/**
 * Convert array to element attributes
 * 
 * @since 1.0.0
 * 
 * @param	array	$atts	Array where key is a attribute name and value is a attribute value
 * @return	string			String with attributes optimized to element
 * ============================================================================
 */
function array2atts( $atts = array() ) {
	if ( empty( $atts ) ) return;
	
	$attributes = '';
	foreach ( $atts as $attr => $value ) {
		if ( ! empty( $value ) ) {
			$value = ( 'href' === $attr || 'src' === $attr ) ? esc_url( $value ) : esc_attr( $value );
			$attributes .= ' ' . $attr . '="' . $value . '"';
		}
	}
	
	return $attributes;
}


/**
 * Retrieve the meta thumbnail info
 * 
 * @since 1.0.0
 * 
 * @param	int		$thumb_id	Thumbnail id
 * @param	string	$meta		Meta thumbnail info wanted
 * @return	string				String with attributes optimized to element
 * ============================================================================
 */
function get_post_thumbnail_meta( $thumb_id, $meta ) {
	$thumb = get_post( $thumb_id );
	
	$thumb = array(
		'src'			=> $thumb->guid,
		'href'			=> esc_url( get_permalink( $thumb->ID ) ),
		'title'			=> $thumb->post_title,
		'caption'		=> $thumb->post_excerpt,
		'alt'			=> get_post_meta( $thumb->ID, '_wp_attachment_image_alt', true ),
		'description'	=> $thumb->post_content
	);
	
	return $thumb[$meta];
}


/**
 * Returns date as link
 *
 * @since 1.0.0
 */
function id_date_link( $sep = null, $echo = true ) {
	$sep		= ( empty( $sep ) ) ? __( 'of' ) : $sep;
	$str_title	= __( 'Posts of %s', ID_THEME_NAME );
	$link_str	= '<a href="%s" title="%s" rel="bookmark">%s</a>';

	$y			= get_the_time( 'Y' );
	$y_title	= esc_attr( sprintf( $str_title, $y ) );
	$y_link		= sprintf( $link_str, get_year_link( $y ), $y_title, $y );

	$m			= get_the_time( 'm' );
	$m_name		= ucfirst( get_the_time( 'F' ) );
	$m_title	= esc_attr( sprintf( $str_title, get_the_time( 'F \d\e Y' ) ) );
	$m_link		= sprintf( $link_str, get_month_link( $y, $m ), $m_title, $m_name );

	$d			= get_the_time( 'd' );
	$d_title	= esc_attr( sprintf( $str_title, get_the_time( get_option( 'date_format' ) ) ) );
	$d_link		= sprintf( $link_str, get_day_link( $y, $m, $d ), $d_title, $d );

	$time_title		= esc_attr( get_the_time( 'l, ' . get_option( 'date_format' ) . ', '. get_option( 'time_format' ) ) );
	$time_datetime	= esc_attr( get_the_date( 'c' ) );

	$output  = sprintf( '<time class="entry-date published updated" title="%s" datetime="%s">' , $time_title, $time_datetime );
	$output .= sprintf( __( '%1$s %4$s %2$s %4$s %3$s' ), $d_link, $m_link, $y_link, $sep );
	$output .= '</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$output .= sprintf( '<time class="updated hidden" datetime="%s">%s</time>',
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);
	}

	if ( $echo ) {
		echo $output;
	} else {
		return $output;
	}
}



/**
 * Função para leitura de diretórios
 * 
 * @since 1.0.0
 * ============================================================================
 */
function idwp_readdir( $dir, $type = FALSE ) {
	$files = array();
	$ds = DIRECTORY_SEPARATOR;
	
	// Se não existir o diretório...
	if ( ! is_dir( $dir ) ) return false;
	
	// Abrindo diretório...
	$odir = @opendir( $dir );
	
	// Se falhar ao abrir o diretório...
	if ( ! $odir ) return false;
	
	// Construindo o array de arquivos...
	while ( ( $file = readdir( $odir ) ) !== false ) :
		// Ignora os resultados "." e ".." ...
		if ( $file == '.' || $file == '..' ) continue;
		
		$slug = explode( '.', $file );
		$ext = ( count( $slug ) == 1 ) ? 'dir' : end( $slug );					// Extensão do arquivo
		$path = ( count( $slug ) == 1 ) ? $dir . $file . $ds : $dir . $file;	// Caminho do arquivo
		$slug = str_replace( '.' . $ext, '', $file );							// Nome do arquivo
		
		if ( is_dir( $path ) ) :
			$files[$slug] = array(
				'type' 	=> $ext,
				'name' 	=> $slug,
				'path' 	=> $path,
				'files' => read_dir( $path, $type )
			);
			continue;
		endif;
		
		// Pegar todos os arquivos
		if ( empty( $type ) ) :
			$files[$slug] = array(
				'type' => $ext,
				'name' => $slug,
				'path' => $path
			);
			continue;
		endif;
		
		// Pegar apenas os diretórios
		if ( $type === 1 ) :
			if ( is_dir( $path ) ) :
				$files[$slug] = array(
					'type' 	=> $ext,
					'name' 	=> $slug,
					'path' 	=> $path,
					'files' => read_dir( $dir, $type )
				);
			endif;
			continue;
		endif;
		
		// Se $type for um array
		if ( is_array( $type ) ) :
			if ( in_array( $ext, $type ) ) :
				$files[$slug] = array(
					'type' => $ext,
					'name' => $slug,
					'path' => $path
				);
			endif;
			continue;
		endif;
		
		// Se $type for uma string
		if ( $ext == $type ) :
			$files[$slug] = array(
				'type' => $ext,
				'name' => $slug,
				'path' => $path
			);
			continue;
		endif;
	endwhile;
	
	// Fechando diretório...
	closedir( $odir );
	
	return $files;
}
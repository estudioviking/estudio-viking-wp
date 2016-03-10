jQuery(document).ready(function($) {
	//var $window, $body, $wpadminbar, $navbar_header;
	var	$window			= $( window ),
		$body			= $( document.body ),
		$wpadminbar		= $( '#wpadminbar' ).first(),
		$navbar_header	= $( '#nav-header.navbar-fixed-top' ).first();

	// Fix Navbar Header with WP Admin Bar
	function navbar_resize() {
		if ( $navbar_header.hasClass( 'navbar-fixed-top' ) ) {
			if ( $wpadminbar.height() ) {
				$navbar_header.attr( 'style', 'top: ' + $wpadminbar.height() + 'px;' );

				if ( 600 >= $window.width() ) {
					$navbar_header.attr( 'style', 'top: ' + $wpadminbar.height() + 'px;' );
				}
			}

			$body.attr( 'style', 'padding-top: ' + ( $navbar_header.height() ) + 'px;' );
		}
	}

	// Fix Nav Header
	navbar_resize();
	$window.resize( navbar_resize );

	// Tabs.
	$( '.evwp-tabs a' ).click(function(e) {
		e.preventDefault();
		$(this).tab( 'show' );
	});

	// Tooltip.
	$( '.evwp-tooltip' ).tooltip();


});
jQuery(document).ready(function($) {
	var	$window			= $( window ),
		$body			= $( document.body ),
		$wpadminbar		= $( '#wpadminbar' ).first(),
		$navbar_header	= $( '#nav-header' ).first();

	// Fix Navbar Header with WP Admin Bar
	function navbar_fix() {
		if ( $navbar_header.hasClass( 'navbar-fixed-top' ) ) {
			if ( $wpadminbar.height() ) {
				$navbar_header.attr( 'style', 'top: ' + $wpadminbar.outerHeight() + 'px;' );

				if ( 600 >= $window.width() ) {
					$navbar_header.attr( 'style', 'top: ' + $wpadminbar.outerHeight() + 'px;' );
				}
			}

			$body.attr( 'style', 'padding-top: ' + ( $navbar_header.outerHeight() ) + 'px;' );
		}
	}

	// Fix Nav Header
	navbar_fix();
	$window.resize( navbar_fix );

	// Tabs.
	$( '.evwp-tabs a' ).click(function(e) {
		e.preventDefault();
		$(this).tab( 'show' );
	});

	// Tooltip.
	$( '.evwp-tooltip' ).tooltip();


});
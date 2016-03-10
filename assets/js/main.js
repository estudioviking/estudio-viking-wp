jQuery(document).ready(function($) {
	// Tabs.
	$( '.evwp-tabs a' ).click(function(e) {
		e.preventDefault();
		$(this).tab( 'show' );
	});

	// Tooltip.
	$( '.evwp-tooltip' ).tooltip();
});
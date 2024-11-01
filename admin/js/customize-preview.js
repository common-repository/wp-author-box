/**
 * Live-update changed settings in real time in the Customizer preview.
 */

( function( $ ) {
	var api = wp.customize;

	// Background color.
	api( 'wpab_background', function( value ) {
		value.bind( function( to ) {
			$( 'ul.pt-tab-list li a' ).css( {
				'background': to 
			} );
		} );
	} );
	api( 'wpab_background_hover', function( value ) {
		value.bind( function( to ) {
			$( 'ul.pt-tab-list li.ui-tabs-active a, ul.pt-tab-list li a:hover' ).css( {
				'background': to 
			} );
		} );
	} );

	// Font color.
	api( 'wpab_font_color', function( value ) {
		value.bind( function( to ) {
			$( 'ul.pt-tab-list li a' ).css( {
				'color': to 
			} );
		} );
	} );
	api( 'wpab_font_color_hover', function( value ) {
		value.bind( function( to ) {
			$( 'ul.pt-tab-list li.ui-tabs-active a, ul.pt-tab-list li a:hover' ).css( {
				'color': to 
			} );
		} );
	} );


} )( jQuery );
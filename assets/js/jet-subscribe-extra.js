( function( $, elementor ) {

	'use strict';

	var JetSubscribeExtra = {

		init: function() {
			$( window ).on( 'jet-elements/subscribe', function( event ) {
				var elementId = event.elementId,
					$popup    = $( '.jet-subscribe-extra-popup' );

				$popup.addClass( 'opened-state' );
			});

			$( document ).on( 'click.JetSubscribeExtra', '.jet-subscribe-extra-popup__close, .jet-subscribe-extra-popup__cover', function( event ) {
				var $popup = $( event.currentTarget ).closest( '.jet-subscribe-extra-popup' );

				$popup.removeClass( 'opened-state' );
			} )

		}

	};

	$( window ).on( 'elementor/frontend/init', JetSubscribeExtra.init );


}( jQuery, window.elementorFrontend ) );

/**
 * Sticky header script.
 */

( function( $ ) {

	// Start hide header on scroll down
	var didScroll;
	var veryTop = 0;
	var delta = 5;

	jQuery(window).scroll(function(event){
		didScroll = true;
	});

	setInterval(function() {
		if (didScroll) {
			hasScrolled();
			didScroll = false;
		}
	}, 100);

	function hasScrolled() {
		var header = jQuery('#top-bar');
		var st = jQuery(this).scrollTop();
		var navbarHeight = header.outerHeight();
		var height = jQuery(window).scrollTop();
		var atTop = ( height < (navbarHeight * 2 ) );
		var scrolldown = (st > veryTop && st > (navbarHeight * 2 ));
		var scrollup = (st + jQuery(window).height() < jQuery(document).height());

		// var top = 0;

		// adjust height for admin bar when logged in
		// if ( jQuery( 'body' ).hasClass( 'admin-bar' ) ) {
		// 		top = jQuery( '#wpadminbar' ).height() + 'px';
		// }

		// if mobile menu is open, don't do anything -
		// this avoids a lot of weird scrolling behavior
		if ( $( '#mobile-expand' ).hasClass( 'toggled' ) ) {
			return;
		}

		// Make sure they scroll more than delta
		if(Math.abs(veryTop - st) <= delta)
			return;

		if ( atTop ) {
			header.css({
				'top' : '',
				'position' : 'absolute',
				'box-shadow' : 'none',
			})
				.addClass('top')
				.removeClass('top-sticky');
		}
		else if ( scrolldown && ( height < ((navbarHeight * 2 ) + 300 )) ) {
			// Scroll Down
			header.css({
				'top' : - navbarHeight,
				'position' : 'absolute',
				'box-shadow' : 'none',
			})
				.removeClass('top')
				.addClass('top-sticky');
		}
		else if ( scrolldown ) {

			// Scroll Down
			header.css({
				'top' : - navbarHeight,
				'position' : 'fixed',
				'box-shadow' : 'none',
			})
				.removeClass('top')
				.addClass('top-sticky');

		}
		else if ( scrollup && ( height < ((navbarHeight * 2 ) + 300 )) )  {
			//Scroll Up almost at the top, hide the bar again
			header.css({
				'top' : - navbarHeight,
				'position' : 'fixed',
				'box-shadow' : 'none',
			});
				// .removeClass('top')
				// .addClass('top-sticky');
		}
		else if ( scrollup )  {
			//Scroll Up
			header.css({
				'top' : '',
				'position' : 'fixed',
				'box-shadow' : '0 0 6rem #333333',
			})
				.removeClass('top')
				.addClass('top-sticky'); // slow down the animation
		}

		veryTop = st;
	}
	// End of hide header on on scroll down

	// jQuery( document ).ready( hasScrolled );
	jQuery( window ).resize( hasScrolled );

} )( jQuery );

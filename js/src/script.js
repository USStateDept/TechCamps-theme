/**
 * General site scripts.
 */
( function( $ ) {

	/**
	 * Mobile menu toggler.
	 */
	$( '.mobile-toggle .hamburger' ).click( function() {
		var button = $( this );
		var menu   = $( '.mobile-expand' );

		if ( button.hasClass( 'is-active' ) ) {
			button
				.removeClass( 'is-active' )
				.attr( 'aria-expanded', false );
			menu
				.removeClass( 'toggled' )
				.attr( 'aria-expanded', false );
		} else {
			button
				.addClass( 'is-active' )
				.attr( 'aria-expanded', true );
			menu
				.addClass( 'toggled' )
				.attr( 'aria-expanded', true );
		}
	} );

	/**
	 * Table wrapper.
	 */
	$( 'table' ).wrap( '<div class="table-wrapper"></div>' );

	/**
	 * Generic toggler.
	 */
	$( '.toggler, .bios__more' ).click( function( e ) {
		e.preventDefault();
		var content = $( this ).siblings( '.toggler-content' );

		if ( $( this ).hasClass( 'bios__more' ) ) {
			content = $( this ).parent().next();
		}

		// swap out text
		var altText = $( this ).data( 'alt' );
		$( this ).data( 'alt', $( this ).text() );
		$( this ).text( altText );

		if ( content.hasClass( 'toggled' ) ) {

			// remove classes
			content.removeClass( 'toggled' );
			$( this ).removeClass( 'toggled' );

			// var scroll = $( this ).hasClass( 'bios__more' )
			// 	? $( this ).offset().top - 200
			// 	: $( this ).offset().top - window.innerHeight + 200;

			if ( $( this ).hasClass( 'bios__more' ) ) {

			} else {

				// scroll back up to button
				$( 'html, body' ).animate( {
					scrollTop: $( this ).offset().top - window.innerHeight + 200
				}, 600 );

			}

		} else {

			// add classes
			content.addClass( 'toggled' );
			$( this ).addClass( 'toggled' );

		}
	} );

	/**
	 * Header search form toggling.
	 */
	$( '#header-search-toggle' ).click( function( e ) {
		e.preventDefault();
		var form = $( '#header-search-form' );
		if ( form.hasClass( 'toggled' ) ) {
			$( this ).removeClass( 'active' );
			form.removeClass( 'toggled' );
		} else {
			$( this ).addClass( 'active' );
			form.addClass( 'toggled' );
		}
	} );

	/**
	 * Resource filter dropdown toggling.
	 */
	$( '.resource-filters__label' ).click( function() {
		var checklist = $( this ).next( '.resource-filters__checklist' );
		if ( checklist.hasClass( 'toggled' ) ) {
			checklist.removeClass( 'toggled' );
		} else {
			$( this ).closest( 'form' ).find( '.resource-filters__checklist' ).removeClass( 'toggled' );
			checklist.addClass( 'toggled' );
		}
	} );

	/**
	 * Establish the correct aspect ratio for Flickr embeds.
	 */
	$( '.flickr-gallery__item a[data-flickr-embed="true"] > img' ).each( function() {
		var iframe = $( this );
		var width  = iframe.attr( 'width' );
		var height = iframe.attr( 'height' );
		var aspectRatio = ( ( height / width ) * 100 ).toFixed( 4 );

		iframe.closest( '.flickr-gallery__container' )
			.find( '.ratio-hack' )
			.css( 'padding-top', aspectRatio + '%' );

	} );

	/**
	 * Set up the type-ahead autocomplete fields on landing pages.
	 */
	$( '#explore-keyword' ).autocomplete( {
		lookup: techcamp_vars.typeaheads,
	} );

} )( jQuery );

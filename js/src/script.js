/**
 * General site scripts.
 */
document.addEventListener("DOMContentLoaded", function() {

	// toggle header search
	var toggle = document.getElementById( 'headersearchtoggle' );
	console.log( toggle );
	toggle.addEventListener( 'click', showSearchForm );
	function showSearchForm() {
		var form = document.getElementById( 'header-search-form' );
		if ( form.classList.contains( 'toggled' ) ) {
			form.classList.remove( 'toggled' );
		} else {
			form.classList.add( 'toggled' );
		}
	}

} );

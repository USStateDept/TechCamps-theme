<?php
/**
 * Initialize the Techcamp map.
 *
 * @package techcamp
 */

/**
 * Google Maps JavaScript API implementation.
 */
class TechCamp_Map {

	static $api_key;

	/**
	 * Add hooks.
	 */
	static function init() {

		self::$api_key = 'AIzaSyDiw8f_hIEJ2TMUirFpB07SqEkBgveC8dE';

		// load script
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts'   ), 11 );
		add_filter( 'script_loader_tag',  array( __CLASS__, 'modify_script_tag' ), 10, 3 );

		// store map info
		add_action( 'save_post', array( __CLASS__, 'get_geolocation' ), 11, 2 ); // lower priority to get access to meta+terms

		// save map info to a json file
		// add_action( 'save_post', array( __CLASS__, 'store_location_data' ), 10, 2 );

	}

	/**
	 * Load the Google Maps JavaScript API.
	 */
	static function enqueue_scripts() {
		if ( is_page_template( 'page-templates/map.php' ) ) {
			wp_enqueue_script( 'google-maps-javascript-api', 'https://maps.googleapis.com/maps/api/js?key=' . self::$api_key . '&callback=initMap', array(), false, true );
		}

		// add Participators array for js availabiliy
		wp_localize_script( 'techcamp-scripts', 'techcamp_map_vars', array(
			'participators' => self::get_participators()
		) );
	}

	/**
	 * Assign extra attributes to Google's javascript tag.
	 */
	static function modify_script_tag( $tag, $handle, $src ) {
		if ( $handle === 'google-maps-javascript-api' ) {
			$tag = '<script async defer src="' . $src . '"></script>' . "\n";
		}
		return $tag;
	}

	/**
	 * Based on an event's descriptive location, get geolocation info (lat, lng)
	 * and store it to the post.
	 */
	static function get_geolocation( $post_id, $post ) {

		if ( !in_array( $post->post_type, array( 'event', 'outcome' ) ) ) {
			return;
		}

		// get city/region
		$address = get_post_meta( $post_id, 'address', true );
		$region  = get_the_terms( $post, 'country' );

		// format into a location string
		$location = $address;
		if ( $region ) {
			$region = array_shift( $region );
			$location .= ', ' . $region->name;
		}

		// create the URL to query Google's geocoding API
		$url = esc_url_raw( add_query_arg( array(
			'address' => urlencode( $location ),
			'key'     => self::$api_key,
		), 'https://maps.googleapis.com/maps/api/geocode/json' ) );

		// retrieve the data
		$response = wp_safe_remote_get( $url );
		$body = wp_remote_retrieve_body( $response );
		if ( !$body ) {
			return;
		}

		// parse out the data to extract location
		$body_array = json_decode( $body );
		$location = isset( $body_array->results[0]->geometry->location ) ? $body_array->results[0]->geometry->location : false;
		if ( !$location ) {
			return;
		}

		// save the data
		update_post_meta( $post_id, 'lat', $location->lat );
		update_post_meta( $post_id, 'lng', $location->lng );

	}

	/**
	 * Get all regions and participating regions and return as an array.
	 *
	 * @todo Do this.
	 * @todo Consider loading from a file instead of generating dynamically each time.
	 * @todo Consider country codes instead of names?
	 */
	static function get_participators() {

		// get all non-empty regions and participators
		$regions = get_terms( array(
			'taxonomy' => array( 'country', 'participator' ),
			'fields'   => 'names'
		) );

		// remove duplicates and keys
		$regions = array_values( array_unique( $regions ) );

		return $regions;

	}

}
TechCamp_Map::init();

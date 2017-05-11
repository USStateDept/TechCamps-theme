<?php
/**
 * Hooks for the Event post type.
 *
 * @package techcamp
 */

/**
 * Turn off TablePress default styles. Generally used on Agenda tables.
 */
add_filter( 'tablepress_use_default_css', '__return_false' );

/**
 * Set table titles in TablePress to H3s.
 */
function techcamp_tablepress_headings( $tag = 'h2', $table_id = 0 ) {
	return 'h3';
}
add_filter( 'tablepress_print_name_html_tag', 'techcamp_tablepress_headings', 10, 2 );

/**
 * Save additional data to Events whenever an event is saved.
 */
function techcamp_save_event_meta( $post_id, $post ) {

	if ( $post->post_type !== 'event' ) {
		return;
	}

	$start = get_post_meta( $post_id, 'start_date', true );

	$tz_meta = techcamp_request_timezone_meta( $post_id, $start );
	$tz_meta = wp_parse_args( $tz_meta, array(
		'dst_offset'  => '',
		'raw_offset'  => '',
		'timezone_id' => '',
	) );

	// save the year
	$year = date( 'Y', (int) $start );
	techcamp_save_hidden_term( $year, 'event_year', $post_id );

	// save the hidden meta
	update_post_meta( $post_id, 'dst_offset',  $tz_meta['dst_offset']  );
	update_post_meta( $post_id, 'raw_offset',  $tz_meta['raw_offset']  );
	update_post_meta( $post_id, 'timezone_id', $tz_meta['timezone_id'] );

}
add_action( 'save_post', 'techcamp_save_event_meta', 11, 3 );

/**
 * Get timezone meta values via a Google Timezone API request.
 */
function techcamp_request_timezone_meta( $post_id = 0, $start = 0 ) {

	$lat = get_post_meta( $post_id, 'lat', true );
	$lng = get_post_meta( $post_id, 'lng', true );

	$tz_url = esc_url_raw( add_query_arg( array(
		'location'  => $lat . ', ' . $lng,
		'timestamp' => $start, // allows us to determine if DST is happening during that time
		'key'       => 'AIzaSyDiw8f_hIEJ2TMUirFpB07SqEkBgveC8dE',
	), 'https://maps.googleapis.com/maps/api/timezone/json' ) );

	// retrieve the data
	$tz_response = wp_safe_remote_get( $tz_url );
	$tz_body     = wp_remote_retrieve_body( $tz_response );

	$tz_id = '';
	if ( $tz_body ) {
		$tz_object   = json_decode( $tz_body );
		$dst_offset  = isset( $tz_object->dstOffset )  ? $tz_object->dstOffset  : '';
		$raw_offset  = isset( $tz_object->rawOffset )  ? $tz_object->rawOffset  : '';
		$tz_id = isset( $tz_object->timeZoneId ) ? $tz_object->timeZoneId : '';
	}

	return array(
		'dst_offset'  => $dst_offset,
		'raw_offset'  => $raw_offset,
		'timezone_id' => $tz_id,
	);

}

/**
 * Register a meta box on the backend showing the data that's been automatically
 * pulled in, for reference.
 */
function techcamp_register_event_meta_box() {
	add_meta_box( 'event-location-data', 'Private Data', 'techcamp_event_meta_box_callback', 'event', 'side' );
}
add_action( 'add_meta_boxes', 'techcamp_register_event_meta_box' );

/**
 * Display the location meta box content.
 */
function techcamp_event_meta_box_callback( $post ) {
	$data = array(
		'lat'         => 'Latitude',
		'lng'         => 'Longitude',
		'timezone_id' => 'Timezone ID',
		'raw_offset'  => 'Offset from GMT',
		'dst_offset'  => 'DST offset (during start date)',
		'year'        => 'Year',
	);

	?>
	<dl>
		<?php foreach( $data as $key => $label ) { ?>
			<dt><?php echo $label; ?></dt>
			<dd>
				<?php if ( $key === 'year' ) {
					$years = strip_tags( get_the_term_list( $post->ID, 'event_year', '', ', ', '' ) );
					if ( $years ) {
						echo esc_html( $years );
					} else { ?>
						<em>Not set</em>
					<?php }
				} else {
					if ( ( $value = get_post_meta( $post->ID, $key, true ) ) !== '' ) {
						echo esc_html( $value );
					} else { ?>
						<em>Not set</em>
					<?php }
				} ?>
			</dd>
		<?php } ?>
	</dl>
	<?php
}

/**
 * If the user is trying to print the agenda, redirect to the print template.
 */
function techcamp_print_redirect( $template ) {

	if ( ! is_singular( 'event' ) ) {
		return $template;
	}

	$print = isset( $_GET['print'] ) ? (int) $_GET['print'] : 0;
	if ( ! $print ) {
		return $template;
	}

	$context = isset( $_GET['context'] ) ? sanitize_key( $_GET['context'] ) : false;
	if ( ! $context ) {
		return $template;
	}

	$new_template = locate_template( array( 'print/print-' . $context . '.php' ) );

	if ( $new_template ) {
		return $new_template;
	}

	return $template;

}
add_action( 'template_include', 'techcamp_print_redirect' );

/**
 * For TechCamp-centric searches, add the 'keyword' query var to the query.
 *
 * This also works for Outcomes.
 */
function techcamp_event_search( $query ) {

	if ( is_admin() || !$query->is_main_query() ) {
		return;
	}

	if ( !is_post_type_archive( array( 'event', 'outcome' ) ) ) {
		return;
	}

	$keyword = techcamp_get_search_query();

	$query->set( 's', $keyword );

}
add_action( 'pre_get_posts', 'techcamp_event_search' );

/**
 * Sort TechCamps by date the event occurred.
 */
function techcamp_event_order( $query ) {

	if ( is_admin() || !$query->is_main_query() ) {
		return;
	}

	if ( !is_post_type_archive( array( 'event' ) ) ) {
		return;
	}

	$query->set( 'meta_key', 'start_date' );
	$query->set( 'orderby', 'meta_value' );

}
add_action( 'pre_get_posts', 'techcamp_event_order' );

/**
 * Run the Event/Outcome search through Relevanssi. This needs to run after
 * the query has been set up.
 */
function techcamp_event_outcome_relevanssi() {

	if ( !function_exists( 'relevanssi_do_query' ) ) {
		return;
	}

	global $wp_query;

	if ( is_admin() || !$wp_query->is_main_query() ) {
		return;
	}

	if ( !is_post_type_archive( array( 'event', 'outcome' ) ) ) {
		return;
	}

	$keyword = isset( $_GET['keyword'] ) ? sanitize_text_field( $_GET['keyword'] ) : false;

	if ( $keyword ) {
		relevanssi_do_query( $wp_query );
	}

}
add_action( 'wp', 'techcamp_event_outcome_relevanssi' );

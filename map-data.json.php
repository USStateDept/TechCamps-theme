<?php

// @todo - replace this with adding events/outcomes to json file whenever they are saved.
// will speed up load w/no stress to server.

include( '../../../wp-load.php' );

header( 'Content-Type: application/json' );

$markers = get_posts( array(
	'post_type'        => array( 'event', 'outcome' ),
	'posts_per_page'   => 500,
	'suppress_filters' => false,
	'fields'           => 'ids',
	'meta_query'       => array(
		'relation'    => 'OR',
		array(
			'key'     => 'exclude_from_map',
			'compare' => '!=',
			'value'   => '1'
		),
		array(
			'key'     => 'exclude_from_map',
			'compare' => 'NOT EXISTS'
		)
	)
) );

$features = array();

foreach( $markers as $id ) {

	// format coordinates
	$coordinates = array(
		(int) get_post_meta( $id, 'lng', true ),
		(int) get_post_meta( $id, 'lat', true )
	);

	// format date
	$start  = get_post_meta( $id, 'start_date', true );
	$end    = get_post_meta( $id, 'end_date', true );
	$format = get_option( 'date_format' );
	if ( !$start ) {
		$date = '';
	} else if ( $start === $end || !$end ) {
		$date = date( $format, $start );
	} else {
		$date = date( $format, $start ) . ' - ' . date( $format, $end );
	}

	// get region
	$regions = get_the_terms( $id, 'country' );
	if ( $regions ) {
		$region = array_shift( $regions );
	}

	// get participating regions
	$participators = get_the_terms( $id, 'participator' );
	$participating_regions = array();
	if ( $participators ) {
		foreach( $participators as $participator ) {
			$participating_regions[] = addslashes( $participator->name );
		}
	}

	// get description
	$desc = get_post_meta( $id, 'short_description', true );

	// get image or fallback
	$img = get_the_post_thumbnail( $id, 'map-thumbnail' );
	if ( !$img ) {
		$img = '<img class="attachment-map-thumbnail" src="' . get_stylesheet_directory_uri() . '/images/world-thumbnail.png" alt="" />';
	}

	// defaults
	$feature = array(
		'type'            => 'Feature',
		'geometry'        => array(
			'type'        => 'Point',
			'coordinates' => $coordinates
		),
		'properties'      => array(
			'name'        => get_the_title( $id ),
			'desc'        => get_post_meta( $id, 'short_description', true ),
			'date'        => $date,
			'url'         => get_permalink( $id ),
			'img'         => $img,
			'icon'        => get_stylesheet_directory_uri() . '/images/marker-event.png',
			'c1'          => isset( $region->name ) ? addslashes( $region->name ) : '',
			'c2'          => $participating_regions
		),
	);

	// conditional rules
	if ( get_post_type( $id ) === 'outcome' ) {
		$feature['properties']['icon'] = get_stylesheet_directory_uri() . '/images/marker-outcome.png';
	}

	$features[] = $feature;

}

$json = array(
	'type'     => 'FeatureCollection',
	'features' => $features
);

echo wp_json_encode( $json );

<?php
/**
 * A static-based class to control the Resource library.
 *
 * @package techcamp
 */
class TechCamp_Resource_Library {

	/**
	 * Form fields in name => label pairs.
	 */
	static public $fields;

	/**
	 * Form values in name => value pairs.
	 */
	static public $values;

	/**
	 * Values
	 */

	/**
	 * Define properties and add hooks.
	 */
	static public function init() {

		self::$fields = array(
			'years'     => 'Years',
			'events'    => 'TechCamps',
			'types'     => 'Types',
			'topics'    => 'Topics',
			'regions'   => 'Regions',
		);

		add_action( 'parse_query',        array( __CLASS__, 'query' ) );
		add_action( 'tha_content_top',    array( __CLASS__, 'form' ) );

	}

	/**
	 * Modify the query for the resources archive page to include bios
	 * and respect the results of the search form.
	 *
	 * Hooks to parse_query and not pre_get_posts as a requirement of
	 * using the Posts to Posts plugin.
	 */
	static public function query( $query ) {

		// only continue in the right context
		if ( is_admin() || !$query->is_main_query() || !is_post_type_archive( 'resource' ) ) {
			return;
		}

		// get what the user searched for
		self::$values = self::get_values();

		// add bios to the main query no matter what
		$query->set( 'post_type', array( 'resource', 'bio' ) );

		// remove empty values
		$searched = array_filter( self::$values );

		// if nothing was searched, return everything
		if ( !$searched ) {
			return;
		}

		// get resources related to events with the following params
		$results = array();
		foreach( array_keys( $searched ) as $field ) {
			switch( $field ) {
				case 'events' :
					$results[] = self::get_resources_by_events();
					break;
				case 'years' :
					$results[] = self::get_resources_by( 'years', 'event_year' );
					break;
				case 'topics' :
					$results[] = self::get_resources_by( 'topics', 'topic' );
					break;
				case 'regions' :
					$results[] = self::get_resources_by( 'regions', 'country' );
					break;
			}
		}

		// if any of the above fields were searched
		if ( !empty( $results ) ) {

			// intersect all found resources to see which match all results
			if ( count( $results ) > 1 ) {
				$resources = call_user_func_array( 'array_intersect', $results );
			} else {
				$resources = array_shift( $results );
			}

			// quit if no resources found
			if ( empty( $resources ) ) {
				$query->set( 'pagename', 'shortcircuit-this-query' );
				return;
			}

			// remove duplicates
			$resources = array_unique( $resources );

			// add resources to main query
			$query->set( 'post__in', $resources );

		}

		// add types to main query
		if ( !empty( self::$values['types'] ) ) {
			$query->set( 'tax_query', array(
				array(
					'taxonomy' => 'resource_type',
					'terms'    => self::$values['types'],
				)
			) );
		}

	}

	/**
	 * Retrieve and sanitize form params.
	 */
	static function get_values() {

		$keys = array_keys( self::$fields );

		$values = array();
		foreach( $keys as $key ) {
			$value = isset( $_GET[$key] ) ? (array) $_GET[$key] : array();
			$value = array_map( 'absint', $value );
			$values[$key] = array_unique( $value );
		}

		return $values;

	}

	/**
	 * Get all resources connected to the given events.
	 */
	static function get_resources_by_events( $events = array() ) {

		if ( empty( $events ) ) {
			$events = self::$values['events'];
		}

		return get_posts( array(
			'suppress_filters' => false,
			'no_found_rows'    => true,
			'fields'           => 'ids',
			'posts_per_page'   => 500,
			'post_type'        => array( 'resource', 'bio' ),
			'connected_type'   => 'resource_connections',
			'connected_items'  => $events,
		) );

	}

	/**
	 * Get all resources connected to an event which contains the given terms.
	 */
	static function get_resources_by( $field, $taxonomy ) {

		$events = get_posts( array(
			'suppress_filters' => false,
			'no_found_rows'    => true,
			'fields'           => 'ids',
			'posts_per_page'   => 500,
			'post_type'        => 'event',
			'tax_query'        => array(
				array(
					'taxonomy' => $taxonomy,
					'terms'    => self::$values[$field],
				),
			),
		) );

		return self::get_resources_by_events( $events );

	}

	/**
	 * Output the resource search form and associated elements.
	 */
	static public function form() {

		// only continue in the right context
		if ( !is_post_type_archive( 'resource' ) ) {
			return;
		}

		// get terms in a simple format
		$taxonomies = array( 'event_year', 'topic', 'country', 'resource_type' );
		$terms = array();
		foreach( $taxonomies as $taxonomy ) {
			$get_terms = get_terms( array( 'taxonomy' => $taxonomy ) );
			$terms[$taxonomy] = array();
			foreach( $get_terms as $term ) {
				$terms[$taxonomy][$term->term_id] = $term->name;
			}
		}

		// get techcamps in a simple format
		$techcamps = array();
		$get_techcamps = get_posts( array(
			'suppress_filters' => false,
			'posts_per_page'   => 500,
			'post_type'        => 'event',
		) );
		foreach( $get_techcamps as $techcamp ) {
			$techcamps[$techcamp->ID] = $techcamp->post_title;
		}

		// line up the fields according to their output
		$fields = array(
			'years' => array(
				'legend' => 'Year',
				'data'   => $terms['event_year'],
			),
			'events' => array(
				'legend' => 'TechCamp',
				'data'   => $techcamps,
			),
			'types' => array(
				'legend' => 'Type',
				'data'   => $terms['resource_type'],

			),
			'topics' => array(
				'legend' => 'Topic',
				'data'   => $terms['topic'],

			),
			'regions' => array(
				'legend' => 'Region',
				'data'   => $terms['country'],
			),
		);

		// get values
		$values = self::get_values();

		?>

		<div class="resource-filters">
			<div class="container resource-filters__container">

				<form method="get" action="<?php echo get_post_type_archive_link( 'resource' ); ?>" class="resource-filters__form">
					<div class="resource-filters__desc">Filter by:</div>

					<?php foreach( $fields as $key => $field ) {
						$field = wp_parse_args( $field, array(
							'legend' => '',
							'data'   => array()
						) ); ?>
						<div class="resource-filters__dropdown">
							<div class="resource-filters__label"><?php echo esc_html( $field['legend'] ); ?></div>
							<div class="resource-filters__checklist">
								<?php foreach( $field['data'] as $id => $label ) { ?>
									<label class="resource-filters__checkline" for="<?php echo esc_attr( $key . '-' . $id ); ?>">
										<input
											id="<?php echo esc_attr( $key . '-' . $id ); ?>"
											type="checkbox" name="<?php echo esc_attr( $key ); ?>[]"
											value="<?php echo esc_attr( $id ); ?>"
											<?php checked( in_array( $id, $values[$key] ) ); ?>
										/>
										<span><?php echo esc_html( $label ); ?></span>
									</label>
								<?php } ?>
							</div>
						</div>
					<?php } ?>

					<input class="button resource-filters__apply" type="submit" value="Apply" />
				</form>

				<?php $values = array_filter( $values );
				if ( $values ) { ?>
					<div class="resource-filters__selections">
						<?php foreach( $values as $field => $values ) {
							switch( $field ) {
								case 'events' :
									foreach( $values as $post_id ) {
										$label = get_the_title( $post_id );
										self::selection( get_the_title( $post_id ), $field, $post_id );
									}
									break;
								case 'years' :
								case 'types' :
								case 'topics' :
								case 'regions' :

									// @todo refactor this travesty
									$taxonomy = '';
									if ( $field === 'years' ) $taxonomy = 'event_year';
									if ( $field === 'types' ) $taxonomy = 'resource_type';
									if ( $field === 'topics' ) $taxonomy = 'topic';
									if ( $field === 'regions' ) $taxonomy = 'country';

									foreach( $values as $term_id ) {
										$term = get_term_by( 'id', $term_id, $taxonomy );
										$term_name = $term ? $term->name : '';
										self::selection( $term_name, $field, $term_id );
									}
									break;
							}
						} ?>
						<a class="resource-filters__clear" href="<?php echo esc_url( get_post_type_archive_link( 'resource' ) ); ?>">Clear</a>
					</div>
				<?php } ?>

			</div><!-- container -->
		</div><!-- .resource-filters -->

		<?php

	}

	/**
	 * Output a specific selection.
	 */
	static public function selection( $label = '', $field = '', $value = 0 ) {
		?>
		<div class="resource-filters__selection button">
			<?php echo esc_html( $label ); ?>
			<?php

				// @todo refactor - pull $_GET values again and build URL that way.

				// get URL
				$query_string = urldecode( $_SERVER['QUERY_STRING'] );

				// remove just the given arg
				$query_string = str_replace( $field . '[]=' . $value, '', $query_string );

				// clean up query string
				$query_string = str_replace( '&&', '&', $query_string );
				$query_string = trim( $query_string, '&' );

				// rebuild URL
				$url = get_post_type_archive_link( 'resources' ) . '?' . $query_string;

			?>
			<a href="<?php echo esc_url( $url ); ?>" class="resource-filters__remove-selection">
				<span class="element-invisible">Remove from search</span>
			</a>
		</div>
		<?php
	}

}
TechCamp_Resource_Library::init();

<?php
/**
 * A static-based class to control the Resource library.
 *
 * @package techcamp
 */
class TechCamp_Resource_Library {

	/**
	 * Info about each field in the form.
	 *
	 * @var array
	 */
	static public $fields;

	/**
	 * Form values in name => value pairs.
	 *
	 * @var array
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
			'types'         => array(
				'label'     => 'Type',
				'type'      => 'taxonomy',
				'taxonomy'  => 'resource_type',
			),
			'languages'     => array(
				'label'     => 'Language',
				'type'      => 'taxonomy',
				'taxonomy'  => 'language',
			),
			'topics'        => array(
				'label'     => 'Topic',
				'type'      => 'taxonomy',
				'taxonomy'  => 'topic',
			),
			'techcamps'     => array(
				'label'     => 'TechCamp',
				'type'      => 'connection',
				'post_type' => 'event',
			),
			'regions'       => array(
				'label'     => 'Country',
				'type'      => 'connection_taxonomy',
				'taxonomy'  => 'country',
			),
			'years'         => array(
				'label'     => 'Year',
				'type'      => 'connection_taxonomy',
				'taxonomy'  => 'event_year',
			),
		);

		add_action( 'parse_query',     array( __CLASS__, 'query' ) );
		add_action( 'tha_content_top', array( __CLASS__, 'form' ), 11 );

	}

	/**
	 * Modify the query for the resources archive page to respect the
	 * results of the search form.
	 *
	 * Hooks to parse_query and not pre_get_posts as a requirement of
	 * using the Posts to Posts plugin.
	 */
	static public function query( $query ) {

		// only continue in the right context
		if ( is_admin() || !$query->is_main_query() || !is_post_type_archive( 'resource' ) ) {
			return;
		}

		// set order
		$query->set( 'meta_key', 'pinned' );
		$query->set( 'orderby', array(
			'meta_value' => 'DESC', // value will either be 1 for pinned or 0 for not pinned, hence DESC
			'name'       => 'ASC',
		) );

		// get what the user searched for
		self::$values = self::get_values();

		// add bios to the main query
		// $query->set( 'post_type', array( 'resource', 'bio' ) );

		// remove empty values
		$searched = array_filter( self::$values );

		// if nothing was searched, return everything
		if ( !$searched ) {
			return;
		}

		//
		// ---- secondary queries: get resources based on related techcamps and those techcamps' terms ----
		//

		// get resources related to the given events
		if ( isset( $searched['techcamps'] ) ) {
			$results[] = self::get_resources_by_techcamps();
		}

		// get resources related to the events that are associated with the given terms
		foreach( self::$fields as $field_name => $field_args ) {

			if ( !isset( $searched[$field_name] ) )
				continue;

			$field_args = wp_parse_args( $field_args, array(
				'type'      => '',
				'taxonomy'  => '',
			) );
			if ( $field_args['type'] === 'connection_taxonomy' ) {
				$results[] = self::get_resources_by( $field_name, $field_args['taxonomy'] );
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

			// if no resources were found, stop early and send back no results
			if ( empty( $resources ) ) {
				$query->set( 'pagename', 'shortcircuit-this-query' );
				return;
			}

			// remove duplicates
			$resources = array_unique( $resources );

			// add resources to main query
			$query->set( 'post__in', $resources );

		}

		//
		// ---- end secondary queries ----
		//

		// add taxonomies to query
		foreach( self::$fields as $field => $args ) {
			if ( !isset( $searched[$field] ) )
				continue;

			$args = wp_parse_args( $args, array(
				'type'      => '',
				'taxonomy'  => '',
			) );

			switch( $args['type'] ) {

				case 'taxonomy' :

					$terms = self::$values[$field];

					if ( $terms ) {

						$query->set( 'tax_query', array(
							array(
								'taxonomy' => $args['taxonomy'],
								'terms'    => $terms,
							)
						) );

					}
					break;

			}

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
	static function get_resources_by_techcamps( $events = array() ) {

		if ( empty( $events ) ) {
			$events = self::$values['techcamps'];
		}

		return get_posts( array(
			'suppress_filters' => false,
			'no_found_rows'    => true,
			'fields'           => 'ids',
			'posts_per_page'   => 500,
			'post_type'        => 'resource', // array( 'resource', 'bio' ),
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

		return self::get_resources_by_techcamps( $events );

	}

	/**
	 * Output the resource search form and associated elements.
	 */
	static public function form() {

		// only continue in the right context
		if ( !is_post_type_archive( 'resource' ) ) {
			return;
		}

		// get values
		$values = self::get_values();

		?>

		<div id="resource-filters" class="resource-filters">
			<div class="container resource-filters__container">

				<form method="get" action="<?php echo get_post_type_archive_link( 'resource' ); ?>#resource-filters" class="resource-filters__form">

					<div class="resource-filters__filters">
						<div class="resource-filters__desc">Filter by:</div>
						<div class="resource-filters__dropdowns">

							<?php foreach( self::$fields as $key => $field ) {

								$field = wp_parse_args( $field, array(
									'label'     => '',
									'type'      => '',
									'taxonomy'  => '',
									'post_type' => '',
								) );

								$data = array();

								switch( $field['type'] ) {

									case 'taxonomy' :
									case 'connection_taxonomy' :

										// countries are special
										if ( $field['taxonomy'] === 'country' ) {
											$terms = get_terms( array(
												'taxonomy'  => $field['taxonomy'],
												'childless' => 'true,'
											) );
										} else {
											$terms = get_terms( array(
												'taxonomy' => $field['taxonomy'],
											) );
										}

										foreach( $terms as $term ) {
											$data[$term->term_id] = $term->name;
										}
										break;

									case 'connection' :
										$post_results = get_posts( array(
											'suppress_filters' => false,
											'posts_per_page'   => 500,
											'post_type'        => $field['post_type'],
										) );
										foreach( $post_results as $result ) {
											$data[$result->ID] = $result->post_title;
										}
										break;

								} ?>

								<div class="resource-filters__dropdown">
									<a href="#" class="resource-filters__label"><?php echo esc_html( $field['label'] ); ?></a>
									<div class="resource-filters__checklist">
										<?php foreach( $data as $id => $label ) { ?>
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
						</div>
					</div>

					<button class="button button--on-dark button--secondary resource-filters__apply" type="submit">Search</button>
				</form>

				<?php $values = array_filter( $values );
				if ( $values ) { ?>
					<div class="resource-filters__selections">
						<div class="resource-filters__desc">Selections:</div>
							<div class="resource-filters__selection-links">
							<?php foreach( $values as $field_name => $values ) {

								$args = self::$fields[$field_name];
								$args = wp_parse_args( $args, array(
									'type'      => '',
									'post_type' => '',
									'taxonomy'  => '',
								) );

								switch( $args['type'] ) {

									case 'taxonomy' :
									case 'connection_taxonomy' :
										foreach( $values as $term_id ) {
											$term = get_term_by( 'id', $term_id, $args['taxonomy'] );
											if ( $term ) {
												self::selection( $term->name, $field_name, $term_id );
											}
										}
										break;

									case 'connection' :
										foreach( $values as $post_id ) {
											self::selection( get_the_title( $post_id ), $field_name, $post_id );
										}
										break;

								}
							} ?>
							<a class="resource-filters__clear" href="<?php echo esc_url( get_post_type_archive_link( 'resource' ) ); ?>#resource-filters">Clear&nbsp;All</a>
						</div>
					</div>
				<?php } ?>

			</div><!-- container -->
		</div><!-- .resource-filters -->

		<?php

	}

	/**
	 * Output a specific selection, with an option to remove it from the search.
	 */
	static public function selection( $label = '', $field = '', $value = 0 ) {

		// get current values
		$values = self::$values;

		// remove empty fields
		$values = array_filter( $values );

		// remove current selection from current values
		$key = array_search( $value, $values[$field] );
		unset( $values[$field][$key] );

		// rebuild query string without current selection
		$url = esc_url_raw( add_query_arg( $values, get_post_type_archive_link( 'resource' ) ) ); ?>

		<div class="resource-filters__selection button">
			<?php echo esc_html( $label ); ?>
			<a href="<?php echo esc_url( $url ); ?>#resource-filters" class="resource-filters__remove-selection">
				<span class="element-invisible">Remove from search</span>
			</a>
		</div>

		<?php
	}

}
TechCamp_Resource_Library::init();

<?php
/**
 * Helper functions to use in templates.
 *
 * @package techcamp
 */

/**
 * Our own debug function.
 */
function techcamp_debug( $debug, $print_r = true ) {

	if ( is_admin() ) {
		echo '<pre style="margin-left:165px;">';
	} else {
		echo '<pre>';
	}

	if ( $print_r ) {
		print_r( $debug );
	} else {
		var_dump( $debug );
	}

	echo '</pre>';

}

/**
 * Return a class based on whether or not there's a featured image.
 */
function techcamp_thumbnail_class( $post = null ) {

	$post = get_post( $post );
	if ( !$post ) {
		return '';
	}

	if ( has_post_thumbnail( $post ) ) {
		return 'has-image';
	} else {
		return 'no-image';
	}

}

/**
 * Return the featured image URL.
 */
function techcamp_thumbnail_url( $post = null ) {

	$post = get_post( $post );
	if ( !$post ) {
		return '';
	}

	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'full' );
	if ( $image ) {
		$image_url = isset( $image[0] ) ? $image[0] : '';
		return $image_url;
	}

	return '';

}

/**
 * Run this function on cmb2 wysiwyg fields to enable auto paragraphs,
 * embeds, and shortcodes. Just like what's allowed in WP content.
 *
 * (Could also filter the field through the_content but this way we
 * avoid any side effects if plugins hook into the_content.)
 */
function techcamp_process_wysiwyg( $meta_key, $post_id = 0 ) {
	global $wp_embed;

	$post_id = $post_id ? $post_id : get_the_ID();

	$content = get_post_meta( $post_id, $meta_key, true );
	$content = $wp_embed->autoembed( $content );
	$content = $wp_embed->run_shortcode( $content );
	$content = wpautop( $content );
	$content = do_shortcode( $content );

	return $content;
}

/**
 * Return a human-readable version of the post location. Works for
 * events and outcomes (and anything with address/region fields).
 */
function techcamp_location( $post = null ) {

	$post = get_post( $post );
	if ( !$post ) {
		return '';
	}

	$address = get_post_meta( get_the_ID(), 'address', true );
	$region  = strip_tags( get_the_term_list( get_the_ID(), 'country' ) );

	if ( $address && $region ) {
		return $address . ', ' . $region;
	} elseif ( !$region ) {
		return $address;
	} elseif ( !$address ) {
		return $region;
	}

}

/**
 * Return a human-readable version of an event date or date range.
 */
function techcamp_event_date( $post = null ) {

	$post = get_post( $post );
	if ( !$post ) {
		return '';
	}

	// stored as unix timestamp
	$start = get_post_meta( get_the_ID(), 'start_date', true );
	$end   = get_post_meta( get_the_ID(), 'end_date', true );

	if ( !$start ) {
		return '';
	}

	if ( !$end ) {
		$end = $start;
	}

	$format = 'F j, Y';

	// if different year
	if ( date( 'Y', $start ) !== date( 'Y', $end ) ) {
		return date( $format, $start ) . '-' . date( $format, $end );

	// if same year, different month
	} else if ( date( 'F', $start ) !== date( 'F', $end ) ) {
		return date( 'F j', $start ) . '-' . date( $format, $end );

	// if same month, different day
	} else if ( date( 'j', $start ) !== date( 'j', $end ) ) {
		return date( 'F j', $start ) . '-' . date( 'j, Y', $end );

	// if same day
	} else if ( $start === $end ) {
		return date( $format, $start );
	}

}

/**
 * Check if an event has already occurred.
 *
 * The trick is to convert the current server date to the given event's time zone,
 * and only then checking against the date of the event.
 */
function techcamp_event_is_upcoming( $post = null ) {

	$post = get_post( $post );
	if ( !$post ) {
		return '';
	}

	// get start date as gmt timestamp
	$start_date = (int) get_post_meta( get_the_ID(), 'start_date', true );

	// get current gmt timestamp
	$gmt_time = time();

	// get time zone offset of event city
	$raw_offset = get_post_meta( get_the_ID(), 'raw_offset', true );
	$dst_offset = get_post_meta( get_the_ID(), 'dst_offset', true );
	$offset = (int) $raw_offset + (int) $dst_offset;

	// get current time of city by combining gmt + offset
	$local_time = $gmt_time + $offset;

	// var_dump( 'Start date: ' . date( 'Y-m-d H:i:s', $start_date ) );
	// var_dump( 'Calculated local time: ' . date( 'Y-m-d H:i:s', $local_time ) );

	// compare start date to that time
	if ( $start_date > $local_time ) {
		return true;
	}

	return false;

}

/**
 * Save a term to a post manually; create the term if it doesn't already exist.
 */
function techcamp_save_hidden_term( $term_slug = '', $taxonomy = '', $post_id = 0, $append = false ) {

	// check if term exists
	$term = get_term_by( 'slug', $term_slug, $taxonomy );

	// get term id
	if ( $term ) {

		$term_id = $term->term_id;

	} else {

		// insert the term beforehand if it doesn't exist
		$term_array = wp_insert_term( $term_slug, $taxonomy, array( 'slug' => $term_slug ) );
		$term_array = wp_parse_args( $term_array, array(
			'term_id' => ''
		) );

		$term_id = $term_array['term_id'];

	}

	// save term to post
	wp_set_object_terms( $post_id, (int) $term_id, $taxonomy, $append ); // need to cast $term_id as int to ensure no confusion with slug

}


/**
 * Display three related items in a row. Used for the From the Blog and
 * Most Recent Outcomes / Most Recent Events sections.
 */
function techcamp_surfaced_posts( $context = '', $title = '', $posts = array(), $button = '', $button_link = '' ) {
	?>
	<div class="surfaced-posts surface-posts--<?php echo esc_attr( $context ); ?>">
		<div class="container surfaced-posts__container">
			<h2 class="surfaced-posts__heading"><?php echo esc_html( $title ); ?></h2>
			<div class="surfaced-posts__row">
				<?php global $post;
				foreach( $posts as $post ) {
					setup_postdata( $post ); ?>
					<div class="surfaced-posts__post">
						<div class="surfaced-posts__post-inner">
							<?php if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'surfaced-thumb', array(
									'class' => 'surfaced-posts__image'
								) );
							} else { ?>
								<img class="surfaced-posts__image default" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/default-thumbnail.jpg" alt="" />
							<?php } ?>
							<div class="surfaced-posts__text">
								<?php if ( get_post_type() === 'post' ) { ?>
									<div class="surfaced-posts__date"><?php the_time( 'm.d.Y' ); ?></div>
								<?php } ?>
								<h3 class="surfaced-posts__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<?php if ( get_post_type() === 'outcome' ) {
									$rel_event = get_posts( array(
										'connected_type'   => 'events_and_outcomes',
										'connected_items'  => $post,
										'posts_per_page'   => 1,
										'suppress_filters' => false,
									) );
									if ( $rel_event ) {
										$rel_event = array_shift( $rel_event ); ?>
										<p class="surfaced-posts__meta"><?php echo esc_html( apply_filters( 'the_title', $rel_event->post_title ) ); ?></p>
									<?php }
								} else if ( get_post_type() === 'event' ) {
									?>
									<p class="surfaced-posts__meta"><?php echo esc_html( techcamp_location() ); ?></p>
									<?php
								} ?>
							</div>
						</div>
					</div>
				<?php }
				wp_reset_postdata(); ?>
			</div>
			<a class="button surfaced-posts__button" href="<?php echo esc_url( $button_link ); ?>">
				<?php echo esc_html( $button ); ?>
			</a>
		</div>
	</div><!-- .surfaced-posts -->
	<?php
}

/**
 * Get a post type label.
 */
function techcamp_get_post_type_label( $post_type = '', $label_type = 'plural' ) {

	$type = get_post_type_object( $post_type );

	if ( $label_type === 'singular' ) {
		$label = isset( $type->labels->singular_name ) ? $type->labels->singular_name : $post_type;

	} else if ( $label_type === 'plural' ) {
		$label = isset( $type->label ) ? $type->label : $post_type;

	} else {
		$label = $post_type;
	}

	if ( $label === 'Post' ) {
		$label = 'Blog';
	}

	/* if ( $label === 'Page' ) {
		$label = '';
	} */

	return sanitize_text_field( $label );

}

/**
 * Get the featured post of a given post type.
 *
 * Featured posts are stored as options i.e. get_option( 'featured_[posttype]' ).
 */
function techcamp_get_featured( $post_type = '' ) {

	if ( !$post_type ) {
		return false;
	}

	$settings = get_option( $post_type . '_settings' );
	$featured_post = isset( $settings['featured_' . $post_type] ) ? $settings['featured_' . $post_type] : false;

	// if not specified, get the latest
	if ( !$featured_post ) {
		$featured_post = get_posts( array(
			'suppress_filters' => false,
			'post_type'        => $post_type,
			'posts_per_page'   => 1,
			'fields'           => 'ids',
		) );
		$featured_post = array_shift( $featured_post );
	}

	if ( $featured_post ) {
		return $featured_post;
	}

	return false;

}

/**
 * Prevent corona_entry_footer_output from running by overriding it.
 */
function corona_entry_footer_output() {}

/**
 * Get the search query of either a basic search or a post-type-centric search.
 *
 * The post type searches use the query var "keyword" instead of "s" to avoid
 * conflicts with WP's basic search.
 */
function techcamp_get_search_query() {

	$query = isset( $_GET['keyword'] ) ? sanitize_text_field( $_GET['keyword'] ) : '';
	if ( $query ) {
		return $query;
	}

	return get_search_query();

}

/**
 * Get search suggestions for events/outcomes (Topics and Regions)
 * and return in js-friendly format. This info is localized and used
 * with the jQuery Autocomplete script.
 */
function techcamp_get_search_suggestions() {

	// get topics
	$topics = get_terms( array( 'taxonomy' => 'topic', 'fields' => 'names' ) );

	// get regions
	$regions = get_terms( array( 'taxonomy' => 'country', 'fields' => 'names' ) );

	$list = array();

	foreach( $topics as $topic ) {
		$topic = wp_specialchars_decode( $topic );
		$list[] = array( 'value' => 'Topic: ' . $topic, 'data' => 'Topic' );
	}

	foreach( $regions as $region ) {
		$region = wp_specialchars_decode( $region );
		$list[] = array( 'value' => 'Region: ' . $region, 'data' => 'Region' );
	}

	return $list;

}

/**
 * Get the post-type-specific link for a generic term.
 */
function techcamp_get_term_link( $term, $taxonomy = '', $post_type = '' ) {

	// posts are normal
	if ( ! $post_type || $post_type === 'post' ) {
		return get_term_link( $term, $taxonomy );
	}

	$archive_url = get_post_type_archive_link( $post_type );

	if ( $post_type === 'resource' || $post_type === 'bio' ) {

		if ( $post_type === 'bio' ) {
			$archive_url = get_post_type_archive_link( 'resource' );
		}

		if ( is_object( $term ) ) {
			$term = $term->term_id;
		}
		$taxonomies = array(
			'resource_type' => 'types',
			'language'      => 'languages',
			'topic'         => 'topics',
		);
		$arg = isset( $taxonomies[$taxonomy] ) ? $taxonomies[$taxonomy] . '[]' : $taxonomy;
		$full_url = add_query_arg( $arg, $term, $archive_url ) . '#resource-filters';

	} else {
		if ( is_object( $term ) ) {
			$term = $term->name;
		}
		$taxonomy = get_taxonomy( $taxonomy );
		$tax_name = $taxonomy->labels->singular_name;
		$full_url = add_query_arg( 'keyword', urlencode( $tax_name . ': ' . $term ), $archive_url );
	}

	return esc_url_raw( $full_url );

}

/**
 * Get the post-type-specific topic link.
 */
function techcamp_get_topic_link( $term, $post_type = '' ) {
	return techcamp_get_term_link( $term, 'topic', $post_type );
}

/**
 * Get the post-type-specific region link.
 */
function techcamp_get_region_link( $term, $post_type = '' ) {
	return techcamp_get_term_link( $term, 'country', $post_type );
}

/**
 * Echo the term list for a specific post using the post-type-specific links above.
 * Assumes a global post is present.
 */
function techcamp_term_list( $taxonomy = '' ) {

	global $post;
	if ( ! $post ) {
		return;
	}

	$tax = get_taxonomy( $taxonomy );
	if ( !$tax ) {
		return;
	}

	$terms = get_the_terms( get_the_ID(), $taxonomy );

	if ( !$terms ) {
		return;
	}

	if ( count( $terms ) === 1 && $terms[0]->name === 'Uncategorized' ) {
		return;
	}

	?>
	<ul class="entry-footer__list entry-footer__list--<?php echo esc_attr( $taxonomy ); ?>">
		<?php foreach( $terms as $term ) { ?>
			<li><a href="<?php echo esc_url( techcamp_get_term_link( $term, $taxonomy, get_post_type() ) ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
		<?php } ?>
	</ul>
	<?php

}

/**
 * Return true if we are on the blog archive page or any blog-related taxonomy page.
 */
function techcamp_is_blog_archive() {
	return is_home() || is_category() || is_tag() || is_tax();
}

/**
 * Get a specific setting.
 */
function techcamp_get_setting( $key = '', $post_type = '' ) {

	if ( !$key ) {
		return false;
	}

	if ( !$post_type ) {
		$setting = 'techcamp_site_settings';
	} else {
		$setting = sanitize_key( $post_type ) . '_settings';
	}

	$values = get_option( $setting );
	$values = wp_parse_args( $values, array(
		$key => ''
	) );

	return $values[$key];

}

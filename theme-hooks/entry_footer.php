<?php
/**
 * Taxonomy terms and related info at the bottom of blog posts.
 *
 * @package techcamp
 */

if ( is_post_type_archive( 'resource' ) ) {

	/* @todo discussion
	global $post;
	$connection = get_posts( array(
		'connected_type'   => 'resource_connections',
		'connected_items'  => array( $post ),
		'posts_per_page'   => 1, // just need one; most resources will only have one
		'suppress_filters' => false,
	) );
	if ( $connection ) {
		$connection = array_shift( $connection );
	}
	// might be an event or an outcome
	if ( $connection ) {
		$post = $connection;
		setup_postdata( $post ); ?>

		<div class="entry-footer__event">
			<h4><?php the_title(); ?></h4>
		</div>

		<?php wp_reset_postdata();
	}
	*/

} else if ( is_post_type_archive() || is_search() ) { ?>

	<div class="entry-footer__container container">
		<?php techcamp_term_list( 'topic' ); ?>
	</div>

<?php } else if ( is_home() || is_category() || is_tag() || is_tax() ) { ?>

	<div class="entry-footer__container container">
		<?php techcamp_term_list( 'topic' ); ?>
		<?php techcamp_term_list( 'post_tag' ); ?>
		<?php techcamp_term_list( 'category' ); ?>
	</div>

<?php } else if ( is_singular( 'post' ) ) { ?>

	<div class="entry-footer__container container">

		<?php // related techcamps/outcomes
		global $post;
		$related_posts = get_posts( array(
			'connected_type'   => 'blog_connections',
			'connected_items'  => array( $post ),
			'posts_per_page'   => 50,
			'no_found_rows'    => true,
			'suppress_filters' => false,
		) );
		if ( $related_posts ) { ?>
			<ul class="entry-footer__list entry-footer__list--related">
				<?php foreach( $related_posts as $post ) {
					setup_postdata( $post );
					?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
				} ?>
			</ul>
		<?php }
		wp_reset_postdata(); ?>

		<?php techcamp_term_list( 'topic' ); ?>
		<?php techcamp_term_list( 'post_tag' ); ?>
		<?php techcamp_term_list( 'category' ); ?>

	</div>

<?php } ?>

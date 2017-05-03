<?php
/**
 * Taxonomy terms and related info at the bottom of blog posts.
 *
 * @package techcamp
 */

if ( is_post_type_archive( 'resource' ) ) {

	techcamp_term_list( 'resource_type' );
	techcamp_term_list( 'topic' );

} else if ( is_post_type_archive() || is_search() ) { ?>

	<div class="entry-footer__container container">
		<?php techcamp_term_list( 'topic' ); ?>

		<?php if ( get_post_type() === 'outcome' ) { ?>
			<div class="archive-entry__location archive-entry__location--footer">
				<?php echo esc_html( techcamp_location() ); ?>
			</div>
		<?php } ?>
	</div>

<?php } else if ( techcamp_is_blog_archive() ) { ?>

	<div class="entry-footer__container container">
		<?php techcamp_term_list( 'topic' ); ?>
		<?php techcamp_term_list( 'category' ); ?>
	</div>

<?php } else if ( is_singular( 'post' ) || is_singular( 'resource' ) ) { ?>

	<div class="entry-footer__container container">

		<?php // related techcamps/outcomes
		global $post;
		$related_posts = get_posts( array(
			'connected_type'   => is_singular( 'resource' ) ? 'resource_connections' : 'blog_connections',
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

		<?php if ( is_singular( 'resource' ) ) { ?>
			<?php techcamp_term_list( 'resource_type' ); ?>
		<?php } ?>
		<?php techcamp_term_list( 'topic' ); ?>
		<?php if ( is_singular( 'post' ) ) { ?>
			<?php techcamp_term_list( 'category' ); ?>
			<?php techcamp_term_list( 'post_tag' ); ?>
		<?php } ?>

	</div>

<?php } ?>

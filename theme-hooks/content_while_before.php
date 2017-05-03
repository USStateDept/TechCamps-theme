<?php
/**
 * Before the while loop.
 *
 * @package techcamp
 */

if ( !is_home() && !is_archive() && !is_search() ) {
	return;
}

global $wp_query; ?>
<h2 class="archive-total">

	<?php if ( is_search() || is_post_type_archive() ) { ?>

		<span class="archive-total__count"><?php echo (int) $wp_query->found_posts; ?></span>
		<?php echo _n( 'Result Found', 'Results Found', $wp_query->found_posts ); ?>
		<?php $query = techcamp_get_search_query();
		if ( $query ) { ?>
			for <span class="archive-total__query"><?php echo esc_html( $query ); ?></span>
		<?php } ?>

	<?php } else {

		$vars = wp_parse_args( $wp_query->query_vars, array(
			'paged'          => 0,
			'posts_per_page' => 10,
		) );

		if ( ! $vars['paged'] ) {
			$vars['paged'] = 1;
		}

		$total = $wp_query->found_posts;

		if ( (int) $total !== 0 ) {
			$high  = (int) $vars['posts_per_page'] * (int) $vars['paged'];
			$low   = $high - (int) $vars['posts_per_page'] + 1;
			if ( $high > $total ) {
				$high = $total;
			}
			$range = $low . '-' . $high; ?>

			Displaying
			<span class="archive-total__count"><?php echo esc_html( $range ); ?></span>
			of
			<span class="archive-total__count"><?php echo (int) $total; ?></span>
			Articles
		<?php } else { ?>
			No Articles Found
		<?php } ?>
		<?php if ( is_category() || is_tag() || is_tax() ) { ?>
			in <?php single_term_title(); ?>
		<?php } ?>

	<?php } ?>

</h2>

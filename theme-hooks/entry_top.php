<?php
/**
 * Top of individual entries.
 *
 * @package techcamp
 */

if ( is_search() ) {

	global $post;
	$label = techcamp_get_post_type_label( get_post_type(), 'singular' );

	if ( $label ) { ?>
		<div class="archive-entry__type"><?php echo esc_html( $label ); ?></div>
	<?php }

} ?>

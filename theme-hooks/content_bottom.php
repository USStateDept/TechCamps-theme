<?php
/**
 * Area right before </main>.
 *
 * @package techcamp
 */

if ( !is_archive() && !is_search() && !is_home() ) {
	return;
}

$pagination = paginate_links( array(
	'prev_text' => 'Prev',
	'next_text' => 'Next',
) );

if ( $pagination ) { ?>

	<div class="pagination">
		<div class="pagination__container container">
			<?php echo $pagination; ?>
		</div>
	</div>

<?php } ?>

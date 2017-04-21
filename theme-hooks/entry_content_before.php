<?php if ( !is_post_type_archive() && !is_search() ) {
	return;
} ?>

<?php if ( get_post_type() === 'event' || get_post_type() === 'outcome' ) { ?>

	<div class="archive-entry__meta">
		<div class="archive-entry__location detail-meta__location">
			<?php echo esc_html( techcamp_location() ); ?>
		</div>
		<?php if( get_post_type() === 'event' ) { ?>
			<div class="archive-entry__date detail-meta__date">
				<?php echo esc_html( techcamp_event_date() ); ?>
			</div>
		<?php } ?>
	</div>

<?php } ?>

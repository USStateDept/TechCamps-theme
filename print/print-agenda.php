<?php
/**
 * The template used for printing/saving the agenda only.
 *
 * @package techcamp
 */

tha_html_before(); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php tha_head_top(); ?>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php tha_head_bottom();?>
	<?php wp_head(); ?>

	<script>
		window.print();
	</script>

	<style>
		@page {
			size:portrait;
		}
	</style>

</head>

<body <?php body_class( 'print print-agenda' ); ?>>

	<div class="agenda">
		<h1>Agenda</h1>
		<?php echo techcamp_process_wysiwyg( 'agenda', get_the_ID() ); ?>
	</div>

	<?php wp_footer(); ?>
</body>
</html>

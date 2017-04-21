<?php
/**
 * Event settings page.
 */
class TechCamp_Event_Settings extends TechCamp_Admin {

	/**
	 * Define properties.
	 */
	function __construct() {
		$this->key = 'event_settings';
		$this->metabox_id = 'event_settings_metabox';
		$this->title = 'Event Settings';
		$this->parent = 'edit.php?post_type=event';
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 */
	function add_options_page_metabox() {

		// hook in our save notices
		add_action( "cmb2_save_options-page_fields_{$this->metabox_id}", array( $this, 'settings_notices' ), 10, 2 );

		$cmb = new_cmb2_box( array(
			'id'         => $this->metabox_id,
			'hookup'     => false,
			'cmb_styles' => true,
			'show_on'    => array(
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		// Set our CMB2 fields

		$cmb->add_field( array(
			'id'         => 'featured_event',
			'name'       => __( 'Featured Event', 'techcamp' ),
			'type'       => 'select',
			'options_cb' => array( $this, 'get_events' ),
		) );

	}

	/**
	 * Return all events in id => title pairs.
	 */
	function get_events() {

		$events = get_posts( array(
			'post_type'        => 'event',
			'order'            => 'ASC',
			'orderby'          => 'title',
			'suppress_filters' => false,
			'posts_per_page'   => 500,
		) );

		$options = array();

		foreach( $events as $event ) {
			$options[$event->ID] = $event->post_title;
		}

		return $options;

	}

}
$event_settings = new TechCamp_Event_Settings();
$event_settings->hooks();

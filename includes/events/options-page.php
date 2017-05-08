<?php
/**
 * TechCamp settings page.
 */
class TechCamp_Event_Settings extends TechCamp_Admin {

	/**
	 * Define properties.
	 */
	function __construct() {
		$this->key = 'event_settings';
		$this->metabox_id = 'event_settings_metabox';
		$this->title = 'TechCamp Settings';
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
			'name' => 'Landing Page',
			'type' => 'title',
			'id'   => 'event_landing_page_title'
		) );

		$cmb->add_field( array(
			'id'         => 'featured_event',
			'name'       => __( 'Featured TechCamp', 'techcamp' ),
			'desc'       => __( 'Make sure the selected TechCamp has a featured image.', 'techcamp' ),
			'type'       => 'select',
			'options_cb' => array( $this, 'get_events' ),
		) );

		$cmb->add_field( array(
			'name' => 'Detail Pages',
			'type' => 'title',
			'id'   => 'event_detail_page_title'
		) );

		$cmb->add_field( array(
			'id'         => 'participators_label',
			'name'       => __( 'Participators Label', 'techcamp' ),
			'default'    => 'Participating Regions',
			'type'       => 'text',
		) );

		$cmb->add_field( array(
			'id'         => 'description_label',
			'name'       => __( 'Description Label', 'techcamp' ),
			'default'    => 'Description / Overview of TechCamp',
			'type'       => 'text',
		) );

		$cmb->add_field( array(
			'id'         => 'trainers_label',
			'name'       => __( 'Trainers Label', 'techcamp' ),
			'default'    => 'Trainer Bios',
			'type'       => 'text',
		) );

		$cmb->add_field( array(
			'id'         => 'agenda_label',
			'name'       => __( 'Agenda Label', 'techcamp' ),
			'default'    => 'Agenda',
			'type'       => 'text',
		) );

		$cmb->add_field( array(
			'id'         => 'resources_label',
			'name'       => __( 'Resources Label', 'techcamp' ),
			'default'    => 'Resources',
			'type'       => 'text',
		) );

		$cmb->add_field( array(
			'id'         => 'slack_text',
			'name'       => __( 'Slack Text', 'techcamp' ),
			'desc'       => __( 'Introductory text to the Slack link in the sidebar of TechCamp detail pages.', 'techcamp' ),
			'default'    => 'Did you attend this TechCamp? Attendees can log in and continue the conversation.',
			'type'       => 'textarea',
		) );

		$cmb->add_field( array(
			'id'         => 'rel_outcomes_label',
			'name'       => __( 'Related Outcomes Label', 'techcamp' ),
			'default'    => 'Outcomes',
			'type'       => 'text',
		) );

		$cmb->add_field( array(
			'id'         => 'rel_posts_label',
			'name'       => __( 'Related Posts Label', 'techcamp' ),
			'default'    => 'Related Blog Posts',
			'type'       => 'text',
		) );

		$cmb->add_field( array(
			'id'         => 'rel_links_label',
			'name'       => __( 'Related Links Label', 'techcamp' ),
			'default'    => 'Related Links',
			'type'       => 'text',
		) );

		$cmb->add_field( array(
			'id'         => 'photos_label',
			'name'       => __( 'Photos Label', 'techcamp' ),
			'default'    => 'Photos from this TechCamp',
			'type'       => 'text',
		) );

		$cmb->add_field( array(
			'id'         => 'videos_label',
			'name'       => __( 'Videos Label', 'techcamp' ),
			'default'    => 'Videos from this TechCamp',
			'type'       => 'text',
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

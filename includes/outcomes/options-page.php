<?php
/**
 * Outcome settings page.
 */
class TechCamp_Outcome_Settings extends TechCamp_Admin {

	/**
	 * Define properties.
	 */
	function __construct() {
		$this->key = 'outcome_settings';
		$this->metabox_id = 'outcome_settings_metabox';
		$this->title = 'Outcome Settings';
		$this->parent = 'edit.php?post_type=outcome';
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
			'id'         => 'featured_outcome',
			'name'       => __( 'Featured Outcome', 'techcamp' ),
			'type'       => 'select',
			'options_cb' => array( $this, 'get_outcomes' ),
		) );

	}

	/**
	 * Return all outcomes in id => title pairs.
	 */
	function get_outcomes() {

		$outcomes = get_posts( array(
			'post_type'        => 'outcome',
			'order'            => 'ASC',
			'orderby'          => 'title',
			'suppress_filters' => false,
			'posts_per_page'   => 500,
		) );

		$options = array();

		foreach( $outcomes as $outcome ) {
			$options[$outcome->ID] = $outcome->post_title;
		}

		return $options;

	}

}
$outcome_settings = new TechCamp_Outcome_Settings();
$outcome_settings->hooks();

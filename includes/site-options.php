<?php
/**
 * Site settings page.
 */
class TechCamp_Site_Settings extends TechCamp_Admin {

	/**
	 * Define properties.
	 */
	function __construct() {
		$this->key = 'techcamp_site_settings';
		$this->metabox_id = 'site_settings_metabox';
		$this->title = 'Site Settings';
		$this->parent = 'options-general.php';
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
			'id'   => 'ga_id',
			'name' => 'Google Analytics ID',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'id'   => 'gtm_id',
			'name' => 'Tag Manager ID',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'id'   => 'map_legend',
			'name' => 'Map Legend Settings',
			'type' => 'title',
		) );

		$cmb->add_field( array(
			'id'   => 'map_legend_techcamps',
			'name' => 'TechCamps Label',
			'type' => 'text',
			'default' => 'TechCamps',
		) );

		$cmb->add_field( array(
			'id'   => 'map_legend_outcomes',
			'name' => 'Outcomes Label',
			'type' => 'text',
			'default' => 'Featured Outcomes',
		) );

		$cmb->add_field( array(
			'id'   => 'map_legend_regions',
			'name' => 'Host Countries Label',
			'type' => 'text',
			'default' => 'Host Countries',
		) );

		$cmb->add_field( array(
			'id'   => 'map_legend_participators',
			'name' => 'Participating Countries Label',
			'type' => 'text',
			'default' => 'Participating Countries',
		) );

		$cmb->add_field( array(
			'id'   => 'email_signup_group',
			'name' => 'Email Form Settings',
			'type' => 'title',
		) );

		$cmb->add_field( array(
			'id'   => 'enable_email_signup',
			'name' => 'Enable Email Form',
			'desc' => 'Enable email signup form (will display on Event and Outcome landing pages)',
			'type' => 'checkbox',
		) );

		$cmb->add_field( array(
			'id'      => 'email_heading',
			'name'    => __( 'Email Form Heading', 'techcamp' ),
			'desc'    => 'Only needed if the email form is enabled.',
			'type'    => 'text',
			'default' => 'Keep up to date on TechCamp news and events.',
		) );

		$cmb->add_field( array(
			'id'   => 'email_signup_shortcode',
			'name' => 'Email Form Shortcode',
			'desc' => 'Enter the Formidable shortcode for the Email Signup form. Only needed if the email form is enabled.',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'id'   => 'miscellaneous_settings_group',
			'name' => 'Miscellaneous Settings',
			'type' => 'title',
		) );

		$cmb->add_field( array(
			'id'         => '404_content',
			'name'       => __( '404 Content', 'techcamp' ),
			'desc'       => __( 'Content to display on the 404 page.', 'techcamp' ),
			'type'       => 'wysiwyg',
		) );

	}

}
$site_settings = new TechCamp_Site_Settings();
$site_settings->hooks();

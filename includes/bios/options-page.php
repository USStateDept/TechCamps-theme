<?php
/**
 * Bios settings page.
 */
class TechCamp_Bio_Settings extends TechCamp_Admin {

	/**
	 * Define properties.
	 */
	function __construct() {
		$this->key = 'bio_settings';
		$this->metabox_id = 'bio_settings_metabox';
		$this->title = 'Bio Settings';
		$this->parent = 'edit.php?post_type=bio';
	}

	/**
	 * Add box and fields.
	 */
	function add_options_page_metabox() {

		// hook in our save notices
		add_action( "cmb2_save_options-page_fields_{$this->metabox_id}", array( $this, 'settings_notices' ), 10, 2 );

		$cmb = new_cmb2_box( array(
			'id'         => $this->metabox_id,
			'hookup'     => false,
			'cmb_styles' => true,
			'show_on'    => array(
				'key'    => 'options-page',
				'value'  => array( $this->key, )
			),
		) );

		$cmb->add_field( array(
			'id'         => 'archive_label',
			'name'       => __( 'Breadcrumb Text', 'techcamp' ),
			'default'    => 'Trainers',
			'type'       => 'text',
		) );

		$cmb->add_field( array(
			'id'         => 'archive_url',
			'name'       => __( 'Breadcrumb URL', 'techcamp' ),
			'type'       => 'text_url',
		) );

		$cmb->add_field( array(
			'id'         => 'contact_label',
			'name'       => __( 'Contact Information Label', 'techcamp' ),
			'default'    => 'Contact',
			'type'       => 'text',
		) );

		$cmb->add_field( array(
			'id'         => 'techcamps_label',
			'name'       => __( 'Related TechCamps Label', 'techcamp' ),
			'default'    => 'TechCamps',
			'type'       => 'text',
		) );

	}

}
$bio_settings = new TechCamp_Bio_Settings();
$bio_settings->hooks();

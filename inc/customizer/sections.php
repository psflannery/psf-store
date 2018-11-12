<?php
/**
 * Store test customizer sections.
 *
 * @package Store_test
 */

/**
 * Register the section sections.
 *
 * @param object $wp_customize Instance of WP_Customize_Class.
 *
 * @since store_test 1.0.0
 */
function psf_store_customize_sections( $wp_customize ) {

	// Register the store details section.
	$wp_customize->add_section(
		'psf_store_details_section',
		array(
			'title'       => esc_html__( 'Store Details', 'psf-store' ),
			'description' => esc_html__( 'The address and contact details for the store.', 'psf-store' ),
			'priority'    => 90,
			'panel'       => 'store-options',
		)
	);

	// Register a Header section.
	$wp_customize->add_section(
		'psf_store_header_section',
		array(
			'title'    => esc_html__( 'Header Notices', 'psf-store' ),
			'priority' => 90,
			'panel'    => 'store-options',
		)
	);

	// Register a Footer section.
	$wp_customize->add_section(	
		'psf_store_footer_section',
		array(
			'title'    => esc_html__( 'Footer Notices', 'psf-store' ),
			'priority' => 90,
			'panel'    => 'store-options',
		)
	);

	// Register the Category Titles section.
	$wp_customize->add_section(
		'psf_store_category_titles',
		array(
			'title'       => esc_html__( 'Category Archives', 'psf-store' ),
			'description' => esc_html__( 'Configure the category archive layout.', 'psf-store' ),
			'priority'    => 90,
			'panel'       => 'store-options',
		)
	);

}
add_action( 'customize_register', 'psf_store_customize_sections' );
